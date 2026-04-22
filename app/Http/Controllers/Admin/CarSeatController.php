<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarSeat;
use Illuminate\Http\Request;

class CarSeatController extends Controller
{
    // View list of the seats
    public function index()
    {
        $seats = CarSeat::orderBy('id', 'desc')->paginate(10);
        return view('admin.cars.seats.index', compact('seats'));
    }

    // Save new seat
    public function store(Request $request)
    {
        $request->validate([
            'seats' => 'required|string|max:255|unique:cars_seats,seats'
        ], [
            'seats.unique' => 'This seat already exists in database.'
        ]);

        CarSeat::create([
            'seats' => $request->seats,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.seats.index')->with('success', 'Seat added successfully!');
    }

    // Update seat
    public function update(Request $request, CarSeat $seat)
    {
        $request->validate([
            'seats' => 'required|string|unique:cars_seats,seats,' . $seat->id . '|max:255',
        ]);

        $seat->update([
            'seats' => $request->seats,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.seats.index')->with('success', 'Seat updated successfully.');
    }

    // Destroy seat
    public function destroy(CarSeat $seat)
    {
        $seat->delete();
        return redirect()->route('admin.seats.index')->with('success', 'Seat deleted successfully!');
    }
}
