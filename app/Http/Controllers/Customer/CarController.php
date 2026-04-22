<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return view('customers.cars.index', compact('cars'));
    }

    public function show(Car $car)
    {
        return view('customers.cars.show', compact('car'));
    }
}
