<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\CarColor;
use App\Models\CarFuel;
use App\Models\CarModel;
use App\Models\CarSeat;
use App\Models\CarStatus;
use App\Models\CarTransmission;
use App\Models\CarType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $fuels = CarFuel::orderBy('id', 'desc')->paginate(10);
        // $cars = Car::with('mainImage')->orderBy('id', 'desc')->paginate(10);
        $cars = Car::with(['mainImage', 'brand', 'model', 'status'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        $brands = CarBrand::all();
        $models = CarModel::all();
        $colors = CarColor::all();
        $fuels = CarFuel::all();
        $seats = CarSeat::all();
        $types = CarType::all();
        $transmissions = CarTransmission::all();
        $statuses = CarStatus::all();

        return view('admin.cars.index', compact('cars', 'brands', 'models', 'colors', 'fuels', 'seats', 'types', 'transmissions', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:car_brands,id',
            'model_id' => 'required|exists:car_models,id',
            'color_id' => 'required|exists:car_colors,id',
            'fuel_id' => 'required|exists:car_fuels,id',
            'seat_id' => 'required|exists:car_seats,id',
            'type_id' => 'required|exists:car_types,id',
            'transmission_id' => 'required|exists:car_transmissions,id',
            'status_id' => 'required|exists:car_statuses,id',
            'year' => 'required|integer|min:1990|max:' . date('Y'),
            'price_per_day' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'images' => 'required|array|min:1|max:9',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $car = Car::create($request->only(['name', 'brand_id', 'model_id', 'type_id', 'transmission_id', 'status_id', 'color_id', 'fuel_id', 'seat_id', 'year', 'price_per_day', 'description']));

            if ($request->hasFile('images')) {
                $files = $request->file('images');
                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $index => $file) {
                    $path = $file->store('cars', 'public');
                    $car->images()->create([
                        'image_path' => $path,
                        'is_main' => $index === 0 ? 1 : 0,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.cars.index')->with('success', 'Car created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            // log error
            return back()->withErrors('Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Set the main image for a car.
     */
    public function setMainImage($carId, $imageId)
    {
        $car = Car::findOrFail($carId);
        foreach ($car->images as $img) {
            $img->is_main = $img->id == $imageId ? 1 : 0;
            $img->save();
        }
        return back()->with('success', 'Main image updated!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::with('images', 'brand', 'model', 'color', 'fuel', 'seat', 'type', 'transmission', 'status')->findOrFail($id);
        return view('admin.cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::with('images')->findOrFail($id);

        DB::beginTransaction();

        try {
            foreach ($car->images as $image) {
                if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }

                $image->delete();
            }

            $car->delete();

            DB::commit();

            return redirect()
                ->route('admin.cars.index')
                ->with('success', 'Car deleted successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors('Something went wrong: ' . $e->getMessage());
        }
    }
}
