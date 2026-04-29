<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    // View list of the type
    public function index()
    {
        $types = CarType::orderBy('id', 'desc')->paginate(10);
        return view('admin.cars.types.index', compact('types'));
    }

    // Save new car type
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:car_types,name'
        ], [
            'name.unique' => 'This car type already exists in database.'
        ]);

        CarType::create([
            'name' => $request->name,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.types.index')->with('success', 'Car type added successfully!');
    }

    // Update car type
    public function update(Request $request, CarType $type)
    {
        $request->validate([
            'name' => 'required|string|unique:car_types,name,' . $type->id . '|max:255',
        ]);

        $type->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.types.index')->with('success', 'Types updated successfully.');
    }

    // Destroy types
    public function destroy(CarType $type)
    {
        $type->delete();
        return redirect()->route('admin.types.index')->with('success', 'Types deleted successfully!');
    }
}
