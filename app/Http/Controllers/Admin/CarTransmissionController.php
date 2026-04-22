<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarTransmissions;
use Illuminate\Http\Request;

class CarTransmissionController extends Controller
{
    // View list of the transmissions
    public function index()
    {
        $transmissions = CarTransmissions::orderBy('id', 'desc')->paginate(10);
        return view('admin.cars.transmissions.index', compact('transmissions'));
    }

    // Save new transmission
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cars_transmissions,name'
        ], [
            'name.unique' => 'This transmission already exists in database.'
        ]);

        CarTransmissions::create([
            'name' => $request->name,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.transmissions.index')->with('success', 'Transmission added successfully!');
    }

    // Update transmission
    public function update(Request $request, CarTransmissions $transmission)
    {
        $request->validate([
            'name' => 'required|string|unique:cars_transmissions,name,' . $transmission->id . '|max:255',
        ]);

        $transmission->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.transmissions.index')->with('success', 'Transmission updated successfully.');
    }

    // Destroy transmission
    public function destroy(CarTransmissions $transmission)
    {
        $transmission->delete();
        return redirect()->route('admin.transmissions.index')->with('success', 'Transmission deleted successfully!');
    }
}
