<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesmanController;
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

Route::controller(ProductController::class)->prefix('products')->name('products.')->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
});

Route::controller(BranchController::class)->prefix('branches')->name('branches.')->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
});

Route::controller(SalesmanController::class)->prefix('salesmen')->name('salesmen.')->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
});

Route::controller(ClientController::class)->prefix('clients')->name('clients.')->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
});

Route::controller(SaleController::class)->prefix('sales')->name('sales.')->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
});
