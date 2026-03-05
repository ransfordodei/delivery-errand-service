<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\RiderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\GroupOrderController;

Route::middleware('auth:sanctum')->group(function () {
    // user routes
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    // orders
    Route::apiResource('/orders', OrderController::class);
    // vendor / rider lists
    Route::apiResource('/vendors', VendorController::class)->only(['index', 'show']);
    Route::apiResource('/riders', RiderController::class)->only(['index', 'show']);

    // payments
    Route::post('/orders/{order}/payments', [PaymentController::class, 'store']);

    // group orders
    Route::post('/orders/{order}/group', [GroupOrderController::class, 'store']);
});

// authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


