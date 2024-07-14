<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\BillingAddressController;
use App\Http\Controllers\UserController;

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::put('/users/{id}/deactivate', [UserController::class, 'deactivate']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('categories', CategoryController::class)->except([
        'create', 'edit', 'show'
    ]);
    

    //Route::get('categories/{category}/product-counts', [CategoryController::class, 'productCounts']);
});

// Catgories API Endpoints
Route::get('categories', [CategoryController::class, 'apiIndex']);
Route::post('categories', [CategoryController::class, 'apiStore']);
Route::get('categories/{category}', [CategoryController::class, 'apiShow']);
Route::put('categories/{category}', [CategoryController::class, 'apiUpdate']);
Route::delete('categories/{category}', [CategoryController::class, 'apiDestroy']);
Route::delete('/categories/{category}', 'CategoryController@destroy')->name('categories.destroy');
Route::get('categories-product-counts', [CategoryController::class, 'apiProductCounts']);

// Product API Endpoints
Route::get('products', [ProductController::class, 'apiIndex']);
Route::post('products', [ProductController::class, 'apiStore']);
Route::get('products/{product}', [ProductController::class, 'apiShow']);
Route::put('products/{product}', [ProductController::class, 'apiUpdate']);
Route::delete('products/{product}', [ProductController::class, 'apiDestroy']);

// Inventory API Endpoints
Route::get('inventory', [InventoryController::class, 'apiIndex']);
Route::post('inventory', [InventoryController::class, 'apiStore']);
Route::get('inventory/{inventory}', [InventoryController::class, 'apiShow']);
Route::put('inventory/{inventory}', [InventoryController::class, 'apiUpdate']);
Route::delete('inventory/{inventory}', [InventoryController::class, 'apiDestroy']);

Route::apiResource('inventories', InventoryController::class);

//Customer Products
Route::get('/customer/products', [CustomerProductController::class, 'index']);
Route::get('/customer/products/{product}', [CustomerProductController::class, 'show']);
Route::get('/customer/products', 'App\Http\Controllers\CustomerProductController@index')->name('api.customer.products');

// Cart API Endpoints
Route::post('/carts', [CartController::class, 'store'])->name('api.carts.store');

// Profile - Billing Address
Route::post('/api/billing-addresses', 'BillingAddressController@store')->name('billing-addresses.store');

// Spatie Search
Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('autocomplete');
Route::get('/search', [SearchController::class, 'search'])->name('search');

