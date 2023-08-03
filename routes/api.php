<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(SupplierController::class)->prefix('suppliers')->name('suppliers.')->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
});
