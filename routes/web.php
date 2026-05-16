<?php

use App\Http\Controllers\Admin\CarBrandController;
use App\Http\Controllers\Admin\CarColorController;
use App\Http\Controllers\Admin\CarDiscountRuleController;
use App\Http\Controllers\Admin\CarFuelController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\CarsController;
use App\Http\Controllers\Admin\CarSeatController;
use App\Http\Controllers\Admin\CarStatusController;
use App\Http\Controllers\Admin\CarTransmissionController;
use App\Http\Controllers\Admin\CarTypeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Customer\CarController as CustomerCarController;
use App\Http\Controllers\Customer\CarRentalController;
use App\Http\Controllers\Customer\CustomerDocumentController;
use App\Http\Controllers\Customer\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Models\Car;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredCars = Car::with([
        'brand',
        'model',
        'fuel',
        'seat',
        'transmission',
        'images',
    ])
        ->latest()
        ->take(3)
        ->get();

    return view('home', compact('featuredCars'));
})->name('home');

// List cars
Route::get('/cars', [CustomerCarController::class, 'index'])->name('cars.index');

// Show public car details
Route::get('/cars/{car}', [CustomerCarController::class, 'show'])->name('cars.show');

Route::post('/cars/{car}/rent', [CarRentalController::class, 'store'])->name('customer.cars.rent');

Route::get('/dashboard', function () {
    return view('customer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/document', [CustomerDocumentController::class, 'create'])
        ->name('customer.document.create');

    Route::post('/profile/document', [CustomerDocumentController::class, 'store'])
        ->name('customer.document.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/cars/{car}/favorite', [FavoriteController::class, 'toggle'])
        ->name('customer.favorites.toggle');

    Route::get('/favorites', [FavoriteController::class, 'index'])
        ->name('customer.favorites.index');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');


        // CUSTOMERS
        Route::get('customers', [CustomerController::class, 'index'])
            ->name('customers.index');

        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');

        Route::put('/customers/{customer}', [CustomerController::class, 'update'])
            ->name('admin.customers.update');

        Route::get('customer/{user}', [CustomerController::class, 'show'])
            ->name('customer.show');

        Route::post('customer/documents/{id}/approve', [CustomerController::class, 'approve'])
            ->name('customer.documents.approve');

        Route::post('customer/documents/{id}/reject', [CustomerController::class, 'reject'])
            ->name('customer.documents.reject');

        Route::delete('customer-documents/{document}', [CustomerController::class, 'destroyDocument'])
            ->name('customer.documents.destroy');


        // LOOKUP TABLES CARS
        Route::resource('cars/brands', CarBrandController::class);
        Route::resource('cars/colors', CarColorController::class);
        Route::resource('cars/fuels', CarFuelController::class);
        Route::resource('cars/models', CarModelController::class);
        Route::resource('cars/seats', CarSeatController::class);
        Route::resource('cars/statuses', CarStatusController::class);
        Route::resource('cars/transmissions', CarTransmissionController::class);
        Route::resource('cars/types', CarTypeController::class);


        // MAIN CARS RESOURCE
        Route::resource('cars', CarsController::class);

        Route::post('cars/{car}/set-main-image/{image}', [CarsController::class, 'setMainImage'])->name('cars.setMainImage');
        Route::delete('cars/{car}/images/{image}', [CarsController::class, 'destroyImage'])->name('cars.images.destroy');

        Route::post('/cars/{car}/discount-rules', [CarDiscountRuleController::class, 'store'])
            ->name('cars.discount-rules.store');

        Route::put('/cars/{car}/discount-rules/{discountRule}', [CarDiscountRuleController::class, 'update'])
            ->name('cars.discount-rules.update');

        Route::patch('/cars/{car}/discount-rules/{discountRule}/toggle', [CarDiscountRuleController::class, 'toggle'])
            ->name('cars.discount-rules.toggle');

        Route::delete('/cars/{car}/discount-rules/{discountRule}', [CarDiscountRuleController::class, 'destroy'])
            ->name('cars.discount-rules.destroy');
    });

require __DIR__ . '/auth.php';
