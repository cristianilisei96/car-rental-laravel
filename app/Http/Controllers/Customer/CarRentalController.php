<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Models\RentalStatus;
use App\Services\RentalPriceCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

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

    public function create(Request $request, Car $car, RentalPriceCalculator $calculator)
    {
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

        try {
            $priceDetails = $calculator->calculate($car, $pickupDate, $returnDate);
        } catch (InvalidArgumentException $exception) {
            $pickupDate = now()->addDay()->toDateString();
            $returnDate = now()->addDays(2)->toDateString();

            $priceDetails = $calculator->calculate($car, $pickupDate, $returnDate);
        }

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
            'returnDate'
        ));
    }

    public function store(Request $request, Car $car, RentalPriceCalculator $calculator)
    {
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
            'payment_method' => ['required', Rule::in(['cash', 'card'])],
        ]);

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

        $pendingStatus = RentalStatus::where('slug', 'pending')->firstOrFail();

        Rental::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'status_id' => $pendingStatus->id,
            'pickup_date' => $priceDetails['pickup_date'],
            'return_date' => $priceDetails['return_date'],
            'total_days' => $priceDetails['total_days'],
            'price_per_day' => $priceDetails['price_per_day'],
            'discount_per_day' => $priceDetails['discount_per_day'],
            'subtotal_price' => $priceDetails['subtotal_price'],
            'total_discount' => $priceDetails['total_discount'],
            'total_price' => $priceDetails['total_price'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_method'] === 'card' ? 'pending' : 'unpaid',
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

        $rental->update([
            'status_id' => $cancelledStatus->id,
        ]);

        return back()->with('success', 'Your rental request was cancelled successfully.');
    }
}
