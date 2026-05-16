<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with([
            'brand',
            'model',
            'type',
            'color',
            'fuel',
            'seat',
            'transmission',
            'status',
            'images',
        ])->latest()->paginate(9);

        return view('customer.cars.index', compact('cars'));
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
