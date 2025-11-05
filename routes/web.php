<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WarehouseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login');
})->name('login');

// Web login form submission (non-API)
Route::post('/login', [AuthController::class, 'webLogin'])->name('web.login');

// Protected routes (user must be logged in)
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::post('/warehouses', [WarehouseController::class, 'store'])->name('warehouses.store');

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully');
    })->name('logout');
    

});
