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
use App\Models\User;
use App\Models\Rental;

class DashboardController extends Controller
{
    public function index()
    {
        $customersCount = User::where('is_admin', 0)->count();
        $carsCount = Car::count();
        $brandsCount = CarBrand::count();
        $colorsCount = CarColor::count();
        $modelsCount = CarModel::count();
        $fuelsCount = CarFuel::count();
        $seatsCount = CarSeat::count();
        $statusesCount = CarStatus::count();
        $transmissionsCount = CarTransmission::count();
        $typesCount = CarType::count();

        $rentalsCount = Rental::count();

        $pendingRentalsCount = Rental::whereHas('status', function ($query) {
            $query->where('slug', 'pending');
        })->count();

        $approvedRentalsCount = Rental::whereHas('status', function ($query) {
            $query->where('slug', 'approved');
        })->count();

        $activeRentalsCount = Rental::whereHas('status', function ($query) {
            $query->where('slug', 'active');
        })->count();

        $completedRentalsCount = Rental::whereHas('status', function ($query) {
            $query->where('slug', 'completed');
        })->count();

        $paidRevenue = Rental::where('payment_status', 'paid')->sum('total_price');

        $unpaidRentalsCount = Rental::whereIn('payment_status', ['unpaid', 'pending'])->count();

        return view('admin.dashboard', compact(
            'customersCount',
            'carsCount',
            'brandsCount',
            'colorsCount',
            'modelsCount',
            'fuelsCount',
            'typesCount',
            'transmissionsCount',
            'seatsCount',
            'statusesCount',
            'rentalsCount',
            'pendingRentalsCount',
            'approvedRentalsCount',
            'activeRentalsCount',
            'completedRentalsCount',
            'paidRevenue',
            'unpaidRentalsCount',
        ));
    }
}
