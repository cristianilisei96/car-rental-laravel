<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\RentalStatus;
use Illuminate\Http\RedirectResponse;
use App\Services\CarAvailabilityService;

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
        ]);

        return view('admin.rentals.show', compact('rental'));
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

        $rental->update([
            'status_id' => $approvedStatus->id,
        ]);

        return back()->with('success', 'Rental request approved successfully.');
    }

    public function reject(Rental $rental): RedirectResponse
    {
        if ($rental->status?->slug !== 'pending') {
            return back()->with('warning', 'Only pending rentals can be rejected.');
        }

        $rejectedStatus = RentalStatus::where('slug', 'rejected')->firstOrFail();

        $rental->update([
            'status_id' => $rejectedStatus->id,
        ]);

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

        $rental->update([
            'status_id' => $activeStatus->id,
        ]);

        // car_statuses: 2 = Rented
        $rental->car?->update([
            'status_id' => 2,
        ]);

        return back()->with('success', 'Rental started successfully. Car status changed to rented.');
    }

    public function complete(Rental $rental): RedirectResponse
    {
        if ($rental->status?->slug !== 'active') {
            return back()->with('warning', 'Only active rentals can be completed.');
        }

        $completedStatus = RentalStatus::where('slug', 'completed')->firstOrFail();

        $rental->update([
            'status_id' => $completedStatus->id,
        ]);

        // car_statuses: 1 = Available
        $rental->car?->update([
            'status_id' => 1,
        ]);

        return back()->with('success', 'Rental completed successfully. Car status changed to available.');
    }

    public function cancel(Rental $rental): RedirectResponse
    {
        if (! in_array($rental->status?->slug, ['pending', 'approved'])) {
            return back()->with('warning', 'Only pending or approved rentals can be cancelled.');
        }

        $cancelledStatus = RentalStatus::where('slug', 'cancelled')->firstOrFail();

        $rental->update([
            'status_id' => $cancelledStatus->id,
        ]);

        return back()->with('success', 'Rental cancelled successfully.');
    }
}
