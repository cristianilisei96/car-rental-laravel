<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarBrand; // modelul tău
use App\Models\CarColor;
use App\Models\CarFuel;
use App\Models\CarModel;
use App\Models\CarSeat;
use App\Models\CarStatus;
use App\Models\CarTransmissions;
use App\Models\CarTypes;
use App\Models\User;

// use App\Models\Car;       // dacă vrei să numeri și mașini

class DashboardController extends Controller
{
    public function index()
    {
        $customersCount = User::where('is_admin', 0)->count();
        $carsCount = Car::count();       // număr total mașini (dacă ai tabelul Car)
        $brandsCount = CarBrand::count();
        $colorsCount = CarColor::count();
        $modelsCount = CarModel::count();
        $fuelsCount = CarFuel::count();
        $seatsCount = CarSeat::count();
        $statusesCount = CarStatus::count();
        $transmissionsCount = CarTransmissions::count();
        $typesCount = CarTypes::count();
        // $carsCount   = Car::count();       // număr total mașini (dacă ai tabelul Car)

        // return view('admin.dashboard', compact('brandsCount', 'carsCount'));
        return view('admin.dashboard', compact('customersCount', 'carsCount', 'brandsCount', 'colorsCount', 'modelsCount', 'fuelsCount', 'typesCount', 'transmissionsCount', 'seatsCount', 'statusesCount'));
    }
}
