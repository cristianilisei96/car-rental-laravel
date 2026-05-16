<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarFuel;
use App\Models\CarTransmission;
use App\Models\CarType;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query()
            ->with([
                'brand',
                'model',
                'type',
                'color',
                'fuel',
                'seat',
                'transmission',
                'status',
                'images',
                'discountRules',
            ])
            ->where('status_id', 1); // doar masinile Available

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('brand', function ($brandQuery) use ($search) {
                        $brandQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('model', function ($modelQuery) use ($search) {
                        $modelQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('type', function ($typeQuery) use ($search) {
                        $typeQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('fuel', function ($fuelQuery) use ($search) {
                        $fuelQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        if ($request->filled('fuel_id')) {
            $query->where('fuel_id', $request->fuel_id);
        }

        if ($request->filled('transmission_id')) {
            $query->where('transmission_id', $request->transmission_id);
        }

        $carsByType = $query
            ->latest()
            ->get()
            ->groupBy(fn($car) => $car->type->name ?? 'Other');

        $types = CarType::orderBy('name')->get();
        $fuels = CarFuel::orderBy('name')->get();
        $transmissions = CarTransmission::orderBy('name')->get();

        return view('customer.cars.index', compact(
            'carsByType',
            'types',
            'fuels',
            'transmissions'
        ));
    }

    public function show(Car $car)
    {
        $car->load([
            'brand',
            'model',
            'type',
            'color',
            'fuel',
            'seat',
            'transmission',
            'status',
            'images',
            'discountRules',
        ]);

        return view('customer.cars.show', compact('car'));
    }
}
