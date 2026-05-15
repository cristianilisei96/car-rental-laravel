<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Car $car): RedirectResponse
    {
        $user = Auth::user();

        if ($user->is_admin) {
            abort(403);
        }

        $exists = $user->favoriteCars()
            ->where('cars.id', $car->id)
            ->exists();

        if ($exists) {
            $user->favoriteCars()->detach($car->id);

            return back()->with('success', 'Car removed from favorites.');
        }

        $user->favoriteCars()->attach($car->id);

        return back()->with('success', 'Car added to favorites.');
    }

    public function index()
    {
        $cars = Auth::user()
            ->favoriteCars()
            ->with([
                'brand',
                'model',
                'fuel',
                'seat',
                'transmission',
                'status',
                'images',
            ])
            ->latest('favorites.created_at')
            ->paginate(9);

        return view('customer.favorites.index', compact('cars'));
    }
}
