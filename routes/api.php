<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\WarehouseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group.
|
*/

//Public route (no token required)
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Get authenticated user info
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('api.user');

    // Products listing (with dynamic pricing)
    Route::get('/products', [ProductController::class, 'index'])->name('api.products');

    // Create or update stock records
    Route::post('/stock', [StockController::class, 'store'])->name('api.store');
     Route::get('/warehouses/{id}/report', [WarehouseController::class, 'report'])->name('api.report');
});
