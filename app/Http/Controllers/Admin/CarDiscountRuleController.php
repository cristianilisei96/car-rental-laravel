<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarDiscountRule;
use Illuminate\Http\Request;

class CarDiscountRuleController extends Controller
{
    public function store(Request $request, Car $car)
    {
        $validated = $request->validate([
            'min_days' => ['required', 'integer', 'min:1'],
            'discount_per_day' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $car->discountRules()->updateOrCreate(
            [
                'min_days' => $validated['min_days'],
            ],
            [
                'discount_per_day' => $validated['discount_per_day'],
                'is_active' => $request->boolean('is_active'),
            ]
        );

        return redirect()
            ->route('admin.cars.edit', $car->id)
            ->with('success', 'Discount rule saved successfully.');
    }

    public function toggle(Car $car, CarDiscountRule $discountRule)
    {
        if ($discountRule->car_id !== $car->id) {
            abort(404);
        }

        $discountRule->update([
            'is_active' => ! $discountRule->is_active,
        ]);

        return redirect()
            ->route('admin.cars.edit', $car->id)
            ->with('success', 'Discount rule status updated successfully.');
    }

    public function destroy(Car $car, CarDiscountRule $discountRule)
    {
        if ($discountRule->car_id !== $car->id) {
            abort(404);
        }

        $discountRule->delete();

        return redirect()
            ->route('admin.cars.edit', $car->id)
            ->with('success', 'Discount rule deleted successfully.');
    }
}
