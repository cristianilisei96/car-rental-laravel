<?php

namespace App\Services;

use App\Models\Car;
use Carbon\Carbon;
use InvalidArgumentException;

class RentalPriceCalculator
{
    public function calculate(Car $car, string $pickupDate, string $returnDate): array
    {
        $pickup = Carbon::parse($pickupDate)->startOfDay();
        $return = Carbon::parse($returnDate)->startOfDay();

        if ($return->lessThanOrEqualTo($pickup)) {
            throw new InvalidArgumentException('Return date must be after pickup date.');
        }

        $totalDays = (int) $pickup->diffInDays($return);

        $pricePerDay = (float) $car->price_per_day;
        $discountPerDay = $this->getBestDiscountPerDay($car, $totalDays);

        $subtotalPrice = $pricePerDay * $totalDays;
        $totalDiscount = $discountPerDay * $totalDays;
        $totalPrice = max($subtotalPrice - $totalDiscount, 0);

        return [
            'pickup_date' => $pickup->toDateString(),
            'return_date' => $return->toDateString(),
            'total_days' => $totalDays,
            'price_per_day' => round($pricePerDay, 2),
            'discount_per_day' => round($discountPerDay, 2),
            'subtotal_price' => round($subtotalPrice, 2),
            'total_discount' => round($totalDiscount, 2),
            'total_price' => round($totalPrice, 2),
        ];
    }

    private function getBestDiscountPerDay(Car $car, int $totalDays): float
    {
        $bestRule = $car->discountRules()
            ->where('is_active', true)
            ->where('min_days', '<=', $totalDays)
            ->orderByDesc('discount_per_day')
            ->first();

        return $bestRule ? (float) $bestRule->discount_per_day : 0;
    }
}
