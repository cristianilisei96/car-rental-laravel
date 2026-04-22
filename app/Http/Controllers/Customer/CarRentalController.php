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

        // Restricție: doar clienți cu document aprobat pot închiria
        if (
            $user->is_admin ||
            !$user->documents()->where('status', 'approved')->exists()
        ) {
            return back()->with('error', 'You must have an approved document to rent a car.');
        }

        // Aici poți adăuga validare pentru datele de închiriere
        // $request->validate([...]);

        // Creezi rezervarea (exemplu simplu)
        Rental::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'pickup_date' => $request->pickup_date,
            'return_date' => $request->return_date,
            // alte câmpuri...
        ]);

        return back()->with('success', 'Car rented successfully!');
    }
}
