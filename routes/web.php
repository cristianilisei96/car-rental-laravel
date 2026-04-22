<?php

use App\Http\Controllers\Admin\CarBrandController;
use App\Http\Controllers\Admin\CarColorController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\CarFuelController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\CarSeatController;
use App\Http\Controllers\Admin\CarStatusController;
use App\Http\Controllers\Admin\CarTransmissionController;
use App\Http\Controllers\Admin\CarTypeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Customer\CarController;
use App\Http\Controllers\Customer\CarRentalController;
use App\Http\Controllers\Customer\CustomerDocumentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Listă mașini
Route::get('/cars', [CarController::class, 'index'])->name('customer.cars.index');

// Detalii mașină
Route::get('/cars/{car}', [CarController::class, 'show'])->name('customer.cars.show');

Route::post('/cars/{car}/rent', [CarRentalController::class, 'store'])->name('customer.cars.rent');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/document', [CustomerDocumentController::class, 'create'])
        ->name('customer.document.create');

    Route::post('/profile/document', [CustomerDocumentController::class, 'store'])
        ->name('customer.document.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('admin/customer/{user}', [CustomerController::class, 'show'])->name('admin.customer.show');
    Route::post('admin/customer/documents/{id}/approve', [CustomerController::class, 'approve'])->name('admin.customer.documents.approve');
    Route::post('/admin/customer/documents/{id}/reject', [CustomerController::class, 'reject'])->name('admin.customer.documents.reject');
    Route::delete('/admin/customer-documents/{document}', [CustomerController::class, 'destroyDocument'])->name('admin.customer.documents.destroy');

    Route::resource('admin/cars', AdminCarController::class);
    Route::resource('admin/cars/brands', CarBrandController::class);
    Route::resource('admin/cars/colors', CarColorController::class);
    Route::resource('admin/cars/fuels', CarFuelController::class);
    Route::resource('admin/cars/models', CarModelController::class);
    Route::resource('admin/cars/seats', CarSeatController::class);
    Route::resource('admin/cars/statuses', CarStatusController::class);
    Route::resource('admin/cars/transmissions', CarTransmissionController::class);
    Route::resource('admin/cars/types', CarTypeController::class);
});

require __DIR__ . '/auth.php';
