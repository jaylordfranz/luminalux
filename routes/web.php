<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\CustomerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Admin Dashboard Routes
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/users', function () {
    return view('admin.users');
})->name('admin.users');

Route::get('/admin/products', function () {
    return view('admin.products');
})->name('admin.products');

Route::get('/admin/payments', function () {
    return view('admin.payments');
})->name('admin.payments');

Route::get('/admin/orders', function () {
    return view('admin.orders');
})->name('admin.orders');

Route::get('/admin/reviews', function () {
    return view('admin.reviews');
})->name('admin.reviews');

// Resource route for category management
Route::resource('categories', CategoryController::class);

Route::resource('products', ProductController::class);

Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

Route::resource('suppliers', SupplierController::class);

Route::resource('discounts', DiscountController::class);

Route::get('/admin/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
Route::get('/admin/suppliers', [SupplierController::class, 'index'])->name('admin.suppliers.index');

Route::get('/customer/dashboard', function () {
    return view('customer.dashboard');
})->name('customer.dashboard');

Route::get('/', function () {
    return view('home');
});

Route::get('/customer/profile', function () {
    return view('customer.profile');
})->name('customer.profile');

Route::get('/customer/cart', function () {
    return view('customer.cart');
})->name('customer.cart');

Route::get('/customer/orders', function () {
    return view('customer.orders');
})->name('customer.orders');

Route::get('/customer/reviews', function () {
    return view('customer.reviews');
})->name('customer.reviews');




Route::get('/skincare', [CustomerController::class, 'skincare'])->name('customer.skincare');
Route::get('/makeup', [CustomerController::class, 'makeup'])->name('customer.makeup');
Route::get('/haircare', [CustomerController::class, 'haircare'])->name('customer.haircare');
Route::get('/bodycare', [CustomerController::class, 'bodycare'])->name('customer.bodycare');
