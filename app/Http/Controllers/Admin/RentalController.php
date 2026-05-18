<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\RentalStatus;
use Illuminate\Http\RedirectResponse;
use App\Services\CarAvailabilityService;
use App\Models\RentalEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with([
            'user',
            'car.brand',
            'car.model',
            'car.images',
            'status',
        ])
            ->latest()
            ->paginate(10);

        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load([
            'car.brand',
            'car.model',
            'car.type',
            'car.fuel',
            'car.seat',
            'car.transmission',
            'car.images',
            'status',
            'user.customerProfile',
            'events.user',
            'events.oldStatus',
            'events.newStatus',
        ]);

        return view('admin.rentals.show', compact('rental'));
    }

    public function completeForm(Rental $rental)
    {
        if ($rental->status?->slug !== 'active') {
            return redirect()
                ->route('admin.rentals.show', $rental)
                ->with('warning', 'Only active rentals can be completed.');
        }

        $rental->load([
            'car.brand',
            'car.model',
            'car.images',
            'status',
            'user.customerProfile',
        ]);

        return view('admin.rentals.complete', compact('rental'));
    }

    public function storeMessage(Request $request, Rental $rental)
    {
        if (in_array($rental->status?->slug, ['completed', 'cancelled', 'rejected'])) {
            return back()->with('warning', 'You can no longer send messages for this rental.');
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        RentalEvent::create([
            'rental_id' => $rental->id,
            'user_id' => Auth::id(),
            'type' => 'admin_message',
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Your reply was sent successfully.');
    }

    public function approve(Rental $rental, CarAvailabilityService $availabilityService): RedirectResponse
    {
        if ($rental->status?->slug !== 'pending') {
            return back()->with('warning', 'Only pending rentals can be approved.');
        }

        if (! $availabilityService->isAvailable(
            $rental->car,
            $rental->pickup_date->toDateString(),
            $rental->return_date->toDateString(),
            $rental->id
        )) {
            return back()->with('warning', 'This car already has an approved or active rental for the selected period.');
        }

        $approvedStatus = RentalStatus::where('slug', 'approved')->firstOrFail();

        $oldStatusId = $rental->status_id;

        $rental->update([
            'status_id' => $approvedStatus->id,
        ]);

        $this->createRentalEvent(
            $rental,
            'admin_approved',
            'Rental request approved by admin.',
            $oldStatusId,
            $approvedStatus->id
        );

        return back()->with('success', 'Rental request approved successfully.');
    }

    public function reject(Rental $rental): RedirectResponse
    {
        if ($rental->status?->slug !== 'pending') {
            return back()->with('warning', 'Only pending rentals can be rejected.');
        }

        $rejectedStatus = RentalStatus::where('slug', 'rejected')->firstOrFail();

        $oldStatusId = $rental->status_id;

        $rental->update([
            'status_id' => $rejectedStatus->id,
        ]);

        $this->createRentalEvent(
            $rental,
            'admin_rejected',
            'Rental request rejected by admin.',
            $oldStatusId,
            $rejectedStatus->id
        );

        return back()->with('success', 'Rental request rejected successfully.');
    }

    public function markAsPaid(Rental $rental): RedirectResponse
    {
        if (in_array($rental->status?->slug, ['rejected', 'cancelled', 'completed'])) {
            return back()->with('warning', 'This rental can no longer be marked as paid.');
        }

        if ($rental->payment_status === 'paid') {
            return back()->with('info', 'This rental is already marked as paid.');
        }

        $rental->update([
            'payment_status' => 'paid',
        ]);

        $this->createRentalEvent(
            $rental,
            'payment_marked_paid',
            'Payment marked as paid by admin.'
        );

        return back()->with('success', 'Payment marked as paid successfully.');
    }

    public function start(Rental $rental): RedirectResponse
    {
        if ($rental->status?->slug !== 'approved') {
            return back()->with('warning', 'Only approved rentals can be started.');
        }

        if ($rental->payment_status !== 'paid') {
            return back()->with('warning', 'Payment must be marked as paid before starting the rental.');
        }

        $activeStatus = RentalStatus::where('slug', 'active')->firstOrFail();

        $oldStatusId = $rental->status_id;

        $rental->update([
            'status_id' => $activeStatus->id,
        ]);

        $this->createRentalEvent(
            $rental,
            'rental_started',
            'Rental started by admin.',
            $oldStatusId,
            $activeStatus->id
        );

        // car_statuses: 2 = Rented
        $rental->car?->update([
            'status_id' => 2,
        ]);

        return back()->with('success', 'Rental started successfully. Car status changed to rented.');
    }

    public function complete(Request $request, Rental $rental)
    {
        if ($rental->status?->slug !== 'active') {
            return back()->with('warning', 'Only active rentals can be completed.');
        }

        $validated = $request->validate([
            'actual_return_at' => ['required', 'date'],
            'return_mileage' => ['nullable', 'integer', 'min:0', 'max:9999999'],
            'fuel_level' => ['required', 'string', 'max:50'],
            'return_notes' => ['nullable', 'string', 'max:2000'],
            'damage_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($rental, $validated) {
            $completedStatus = RentalStatus::where('slug', 'completed')->firstOrFail();
            $availableStatus = \App\Models\CarStatus::where('name', 'Available')->firstOrFail();

            $oldStatusId = $rental->status_id;

            $rental->update([
                'status_id' => $completedStatus->id,
                'actual_return_at' => $validated['actual_return_at'],
                'return_mileage' => $validated['return_mileage'] ?? null,
                'fuel_level' => $validated['fuel_level'],
                'return_notes' => $validated['return_notes'] ?? null,
                'damage_notes' => $validated['damage_notes'] ?? null,
            ]);

            $rental->car()->update([
                'status_id' => $availableStatus->id,
            ]);

            $this->createRentalEvent(
                $rental,
                'rental_completed',
                'Rental completed by admin.',
                $oldStatusId,
                $completedStatus->id
            );
        });

        return redirect()
            ->route('admin.rentals.show', $rental)
            ->with('success', 'Rental completed successfully.');
    }

    public function cancel(Rental $rental): RedirectResponse
    {
        if (! in_array($rental->status?->slug, ['pending', 'approved'])) {
            return back()->with('warning', 'Only pending or approved rentals can be cancelled.');
        }

        $cancelledStatus = RentalStatus::where('slug', 'cancelled')->firstOrFail();

        $oldStatusId = $rental->status_id;

        $rental->update([
            'status_id' => $cancelledStatus->id,
        ]);

        $this->createRentalEvent(
            $rental,
            'admin_cancelled',
            'Rental cancelled by admin.',
            $oldStatusId,
            $cancelledStatus->id
        );

        return back()->with('success', 'Rental cancelled successfully.');
    }

    private function createRentalEvent(
        Rental $rental,
        string $type,
        string $message,
        ?int $oldStatusId = null,
        ?int $newStatusId = null
    ): void {
        RentalEvent::create([
            'rental_id' => $rental->id,
            'user_id' => Auth::id(),
            'type' => $type,
            'message' => $message,
            'old_status_id' => $oldStatusId,
            'new_status_id' => $newStatusId,
        ]);
    }
}
