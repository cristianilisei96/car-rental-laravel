<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Models\RentalStatus;
use App\Services\CarAvailabilityService;
use App\Services\RentalPriceCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use InvalidArgumentException;
use App\Models\RentalEvent;

class CarRentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with([
            'car.brand',
            'car.model',
            'car.images',
            'status',
        ])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

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

        return view('customer.rentals.show', compact('rental'));
    }

    public function create(
        Request $request,
        Car $car,
        RentalPriceCalculator $calculator,
        CarAvailabilityService $availabilityService
    ) {
        $user = Auth::user();

        if (! $user->isKycApproved()) {
            return redirect()
                ->route('customer.document.create')
                ->with('warning', 'You need an approved Driver License and an approved ID Card or Passport before renting a car.');
        }

        if (! $user->hasCompleteCustomerProfile()) {
            return redirect()
                ->route('customer.account-details.edit')
                ->with('warning', 'Please complete your account details before renting a car.');
        }

        if ((int) $car->status_id !== 1) {
            return redirect()
                ->route('cars.show', $car)
                ->with('warning', 'This car is not available for rental.');
        }

        $pickupDate = $request->input('pickup_date', now()->addDay()->toDateString());
        $returnDate = $request->input('return_date', now()->addDays(2)->toDateString());

        $pickupTime = $request->input('pickup_time', '09:00');
        $returnTime = $request->input('return_time', '17:00');

        try {
            $priceDetails = $calculator->calculate($car, $pickupDate, $returnDate);
        } catch (InvalidArgumentException $exception) {
            $pickupDate = now()->addDay()->toDateString();
            $returnDate = now()->addDays(2)->toDateString();

            $priceDetails = $calculator->calculate($car, $pickupDate, $returnDate);
        }

        $isAvailableForSelectedDates = $availabilityService->isAvailable(
            $car,
            $priceDetails['pickup_date'],
            $priceDetails['return_date']
        );

        $car->load([
            'brand',
            'model',
            'type',
            'fuel',
            'seat',
            'transmission',
            'images',
            'discountRules',
        ]);

        return view('customer.rentals.create', compact(
            'car',
            'priceDetails',
            'pickupDate',
            'returnDate',
            'pickupTime',
            'returnTime',
            'isAvailableForSelectedDates'
        ));
    }

    public function store(
        Request $request,
        Car $car,
        RentalPriceCalculator $calculator,
        CarAvailabilityService $availabilityService
    ) {
        $user = Auth::user();

        if (! $user->isKycApproved()) {
            return redirect()
                ->route('customer.document.create')
                ->with('warning', 'You need an approved Driver License and an approved ID Card or Passport before renting a car.');
        }

        if (! $user->hasCompleteCustomerProfile()) {
            return redirect()
                ->route('customer.account-details.edit')
                ->with('warning', 'Please complete your account details before renting a car.');
        }

        if ((int) $car->status_id !== 1) {
            return redirect()
                ->route('cars.show', $car)
                ->with('warning', 'This car is not available for rental.');
        }

        $validated = $request->validate([
            'pickup_date' => ['required', 'date', 'after_or_equal:' . now()->addDay()->toDateString()],
            'return_date' => ['required', 'date', 'after:pickup_date'],
            'pickup_time' => [
                'required',
                Rule::in([
                    '09:00',
                    '09:30',
                    '10:00',
                    '10:30',
                    '11:00',
                    '11:30',
                    '12:00',
                    '12:30',
                    '13:00',
                    '13:30',
                    '14:00',
                    '14:30',
                    '15:00',
                    '15:30',
                    '16:00',
                    '16:30',
                    '17:00',
                ]),
            ],
            'return_time' => [
                'required',
                Rule::in([
                    '09:00',
                    '09:30',
                    '10:00',
                    '10:30',
                    '11:00',
                    '11:30',
                    '12:00',
                    '12:30',
                    '13:00',
                    '13:30',
                    '14:00',
                    '14:30',
                    '15:00',
                    '15:30',
                    '16:00',
                    '16:30',
                    '17:00',
                ]),
            ],
            'payment_method' => ['required', Rule::in(['cash', 'card'])],
        ]);

        $pickupDate = \Carbon\Carbon::parse($validated['pickup_date']);
        $returnDate = \Carbon\Carbon::parse($validated['return_date']);

        if ($pickupDate->isWeekend() || $returnDate->isWeekend()) {
            return back()
                ->withInput()
                ->withErrors([
                    'pickup_date' => 'Pick-up and return dates must be business days, Monday to Friday.',
                ]);
        }

        try {
            $priceDetails = $calculator->calculate(
                $car,
                $validated['pickup_date'],
                $validated['return_date']
            );
        } catch (InvalidArgumentException $exception) {
            return back()
                ->withInput()
                ->withErrors([
                    'return_date' => $exception->getMessage(),
                ]);
        }

        if (! $availabilityService->isAvailable($car, $priceDetails['pickup_date'], $priceDetails['return_date'])) {
            return back()
                ->withInput()
                ->with('warning', 'This car is not available for the selected period. Please choose different dates.');
        }

        $pendingStatus = RentalStatus::where('slug', 'pending')->firstOrFail();

        $rental = Rental::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'status_id' => $pendingStatus->id,

            'pickup_date' => $priceDetails['pickup_date'],
            'pickup_time' => $validated['pickup_time'],

            'return_date' => $priceDetails['return_date'],
            'return_time' => $validated['return_time'],

            'total_days' => $priceDetails['total_days'],
            'price_per_day' => $priceDetails['price_per_day'],
            'discount_per_day' => $priceDetails['discount_per_day'],
            'subtotal_price' => $priceDetails['subtotal_price'],
            'total_discount' => $priceDetails['total_discount'],
            'total_price' => $priceDetails['total_price'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_method'] === 'card' ? 'pending' : 'unpaid',
        ]);

        RentalEvent::create([
            'rental_id' => $rental->id,
            'user_id' => $user->id,
            'type' => 'rental_created',
            'message' => 'Rental request created by customer.',
            'new_status_id' => $pendingStatus->id,
        ]);

        return redirect()
            ->route('customer.rentals.index')
            ->with('success', 'Your rental request has been created and is waiting for admin approval.');
    }

    public function cancel(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        if (! in_array($rental->status?->slug, ['pending', 'approved'])) {
            return back()->with('warning', 'This rental can no longer be cancelled.');
        }

        if ($rental->payment_status === 'paid') {
            return back()->with('warning', 'This rental is already paid. Please contact support to cancel it.');
        }

        $cancelledStatus = RentalStatus::where('slug', 'cancelled')->firstOrFail();

        $oldStatusId = $rental->status_id;

        $rental->update([
            'status_id' => $cancelledStatus->id,
        ]);

        RentalEvent::create([
            'rental_id' => $rental->id,
            'user_id' => Auth::id(),
            'type' => 'customer_cancelled',
            'message' => 'Rental cancelled by customer.',
            'old_status_id' => $oldStatusId,
            'new_status_id' => $cancelledStatus->id,
        ]);

        return back()->with('success', 'Your rental request was cancelled successfully.');
    }
}
