<?php

namespace App\Services;

use App\Models\Car;
use Carbon\Carbon;

class CarAvailabilityService
{
    public function isAvailable(Car $car, string $pickupDate, string $returnDate, ?int $ignoreRentalId = null): bool
    {
        return ! $this->hasOverlappingRental($car, $pickupDate, $returnDate, $ignoreRentalId);
    }

    public function hasOverlappingRental(Car $car, string $pickupDate, string $returnDate, ?int $ignoreRentalId = null): bool
    {
        $pickup = Carbon::parse($pickupDate)->toDateString();
        $return = Carbon::parse($returnDate)->toDateString();

        return $car->rentals()
            ->whereHas('status', function ($query) {
                $query->whereIn('slug', ['approved', 'active']);
            })
            ->when($ignoreRentalId, function ($query) use ($ignoreRentalId) {
                $query->where('id', '!=', $ignoreRentalId);
            })
            ->whereDate('pickup_date', '<', $return)
            ->whereDate('return_date', '>=', $pickup)
            ->exists();
    }
}
