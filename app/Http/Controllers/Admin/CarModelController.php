<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    // View list of the models
    public function index()
    {
        $models = CarModel::orderBy('id', 'desc')->paginate(10);
        $brands = CarBrand::all();
        return view('admin.cars.models.index', compact('models', 'brands'));
    }

    // Save new model
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cars_models,name',
            'brand_id' => 'required|exists:cars_brands,id',
        ], [
            'name.unique' => 'This model already exists in database.'
        ]);

        CarModel::create([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'created_at' => now(),
        ]);

        return redirect()->route('models.index')->with('success', 'Model added successfully!');
    }

    // Update model
    public function update(Request $request, CarModel $model)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|unique:cars_models,name,' . $model->id . '|max:255',
            'brand_id' => 'required|exists:cars_brands,id',
        ]);

        $model->update([
            'name' => $request->name,
            'brand_id' => $request->brand_id,
            'updated_at' => now(),
        ]);

        return redirect()->route('models.index')->with('success', 'Model updated successfully.');
    }

    // Destroy model
    public function destroy(CarModel $car_model)
    {
        $car_model->delete();
        return redirect()->route('cars_models.index')->with('success', 'Model deleted successfully!');
    }
}
