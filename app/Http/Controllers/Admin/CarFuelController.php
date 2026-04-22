<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarFuel;
use Illuminate\Http\Request;

class CarFuelController extends Controller
{
    // View list of the fuels
    public function index()
    {
        $fuels = CarFuel::orderBy('id', 'desc')->paginate(10);
        return view('admin.cars.fuels.index', compact('fuels'));
    }

    // Save new fuel
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cars_fuels,name'
        ], [
            'name.unique' => 'This fuel already exists in database.'
        ]);

        CarFuel::create([
            'name' => $request->name,
            'created_at' => now(),
        ]);

        return redirect()->route('fuels.index')->with('success', 'Fuel added successfully!');
    }

    // Update fuel
    public function update(Request $request, CarFuel $fuel)
    {
        $request->validate([
            'name' => 'required|string|unique:cars_fuels,name,' . $fuel->id . '|max:255',
        ]);

        $fuel->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->route('fuels.index')->with('success', 'Fuel updated successfully.');
    }

    // Destroy fuel
    public function destroy(CarFuel $fuel)
    {
        $fuel->delete();
        return redirect()->route('fuels.index')->with('success', 'Fuel deleted successfully!');
    }
}
