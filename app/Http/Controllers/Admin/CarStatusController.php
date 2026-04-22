<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarStatus;
use Illuminate\Http\Request;

class CarStatusController extends Controller
{
    // View list of the status
    public function index()
    {
        $statuses = CarStatus::orderBy('id', 'desc')->paginate(10);
        return view('admin.cars.statuses.index', compact('statuses'));
    }

    // Save new status
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cars_statuses,name'
        ], [
            'name.unique' => 'This status already exists in database.'
        ]);

        CarStatus::create([
            'name' => $request->name,
            'created_at' => now(),
        ]);

        return redirect()->route('statuses.index')->with('success', 'Status added successfully!');
    }

    // Update statu
    public function update(Request $request, CarStatus $status)
    {
        $request->validate([
            'name' => 'required|string|unique:cars_statuses,name,' . $status->id . '|max:255',
        ]);

        $status->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->route('statuses.index')->with('success', 'Status updated successfully.');
    }

    // Destroy statu
    public function destroy(CarStatus $status)
    {
        $status->delete();
        return redirect()->route('statuses.index')->with('success', 'Status deleted successfully!');
    }
}
