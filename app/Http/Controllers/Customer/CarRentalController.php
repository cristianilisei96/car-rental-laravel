<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class CarRentalController extends Controller
{
    public function store(Request $request, Car $car)
    {
        $user = auth()->user();

        // Restrictie: doar clienti cu document aprobat pot inchiria
        if (
            $user->is_admin ||
            !$user->documents()->where('status', 'approved')->exists()
        ) {
            return back()->with('error', 'You must have an approved document to rent a car.');
        }

        // $request->validate([...]);

        Rental::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'pickup_date' => $request->pickup_date,
            'return_date' => $request->return_date,
        ]);

        return back()->with('success', 'Car rented successfully!');
    }
}
