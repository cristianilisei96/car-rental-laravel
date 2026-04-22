<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    // View list of the brands
    public function index()
    {
        $brands = CarBrand::orderBy('id', 'desc')->paginate(10);
        return view('admin.cars.brands.index', compact('brands'));
    }

    // Save new brand
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:cars_brands,name|max:255',
        ], [
            'name.unique' => 'This brand already exists in database.'
        ]);

        CarBrand::create([
            'name' => $request->name,
            'created_at' => now(),
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand added successfully.');
    }

    // Update brand
    public function update(Request $request, CarBrand $brand)
    {
        $request->validate([
            'name' => 'required|string|unique:cars_brands,name,' . $brand->id . '|max:255',
        ]);

        $brand->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    // Destroy brand
    public function destroy(CarBrand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
}
