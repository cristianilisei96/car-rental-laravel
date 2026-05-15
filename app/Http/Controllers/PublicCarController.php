<?php

namespace App\Http\Controllers;

use App\Models\Car;

class PublicCarController extends Controller
{
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
        ]);

        return view('customer.cars.show', compact('car'));
    }
}
