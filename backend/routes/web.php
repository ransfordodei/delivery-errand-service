<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\PaymentController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Orders
    Route::resource('orders', OrderController::class);
    Route::post('/orders/{order}/assign-rider', [OrderController::class, 'assignRider'])->name('orders.assignRider');
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Vendors
    Route::resource('vendors', VendorController::class);

    // Riders
    Route::resource('riders', RiderController::class);
    Route::post('/riders/{rider}/update-status', [RiderController::class, 'updateStatus'])->name('riders.updateStatus');

    // Payments
    Route::resource('payments', PaymentController::class, ['only' => ['index', 'create', 'store', 'show', 'destroy']]);
    Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');
    Route::get('/orders/{order}/payments', [PaymentController::class, 'index'])->name('orders.payments.index');
    Route::get('/orders/{order}/payments/create', [PaymentController::class, 'create'])->name('orders.payments.create');
    Route::post('/orders/{order}/payments', [PaymentController::class, 'store'])->name('orders.payments.store');
});