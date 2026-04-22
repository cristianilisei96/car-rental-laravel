<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarColor;
use Illuminate\Http\Request;

class CarColorController extends Controller
{
    // View list of the colors
    public function index()
    {
        $colors = CarColor::orderBy('id', 'desc')->paginate(10);
        return view('admin.cars.colors.index', compact('colors'));
    }

    // Save new brand
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:cars_colors,name|max:255',
        ], [
            'name.unique' => 'This brand already exists in database.'
        ]);

        CarColor::create([
            'name' => $request->name,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.colors.index')->with('success', 'Color added successfully!');
    }

    // Update color
    public function update(Request $request, CarColor $color)
    {
        $request->validate([
            'name' => 'required|unique:cars_colors,name,' . $color->id . '|max:255',
        ]);

        $color->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.colors.index')->with('success', 'Color updated successfully!');
    }

    // Destroy color
    public function destroy(CarColor $color)
    {
        $color->delete();
        return redirect()->route('admin.colors.index')->with('success', 'Color deleted successfully!');
    }
}
