<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\BillingAddressController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\OrderController;


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

// User Management
Route::resource('users', UserController::class);
Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/admin/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');

// Admin Dashboard Routes
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/users', function () {
    return view('admin.users.index');
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

Route::delete('categories/{category}', [CategoryController::class, 'apiDestroy']);
Route::post('categories/importExcel', [CategoryController::class, 'importExcel'])->name('categories.importExcel');

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

Route::prefix('admin')->group(function () {
    Route::resource('inventory', InventoryController::class);
});

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

Route::get('/admin/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');

Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory.index');


Route::get('/admin/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
Route::get('/admin/suppliers', [SupplierController::class, 'index'])->name('admin.suppliers.index');

// Charts
Route::get('/admin/dashboard/category-product-chart', [CategoryController::class, 'productCounts']);

// Customer
Route::get('/register', function () {
    return view('customer.register');
})->name('register');

Route::get('/login', function () {
    return view('customer.login');
})->name('login');

Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);

Route::middleware(['auth:customer'])->group(function () {
    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

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

// Customer Profile
Route::get('/customer/profile', [CustomerProfileController::class, 'index'])->name('customer.profile');

Route::middleware('auth:customer')->group(function () {
    Route::post('/billing-addresses/store', [BillingAddressController::class, 'store'])->name('billing-addresses.store');
    Route::delete('/billing-addresses/{id}', [BillingAddressController::class, 'destroy'])->name('billing-addresses.destroy');
});

Route::middleware('auth:customer')->group(function () {
    Route::get('/customer/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile');
    Route::put('/customer/profile/update', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
});

Route::middleware(['auth:customer'])->group(function () {
    // Routes for edit profile and billing addresses
    // Route::get('/customer/profile', [CustomerProfileController::class, 'index'])->name('customer.profile');
    Route::put('/customer/profile/update', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
    //Route::post('/customer/profile/store', [BillingAddressController::class, 'store'])->name('customer.profile.store');
    // Route::delete('/billing-addresses/{id}', [BillingAddressController::class, 'destroy'])->name('billing-addresses.destroy');
    // Route for storing billing addresses
});

Route::post('/customer/address', [BillingAddressController::class, 'store'])->name('customer.address.store');

// View product details
// routes/web.php
Route::get('/customer/product-details/{id}', [CustomerProductController::class, 'show'])->name('customer.product-details');
// routes/web.php
Route::get('customer/product-details/{product}', [ProductController::class, 'show'])->name('customer.product-details');
Route::get('/customer/dashboard', [CustomerProductController::class, 'dashboard'])->name('customer.dashboard');
Route::prefix('customer')->group(function () {
    Route::post('/add-to-cart/{id}', [CustomerProductController::class, 'addToCart'])
         ->name('customer.add_to_cart');
});

Route::resource('carts', CartController::class);

//Spatie Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// Cart
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
    Route::get('/cart', [CartController::class, 'index'])->name('customer.cart');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
});

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('customer.add-to-cart')->middleware('auth:customer');

// Route to the shopping cart page
Route::get('/cart', [CartController::class, 'showCart'])->name('customer.cart')->middleware('auth:customer');

// Route to remove an item from the cart
Route::delete('/cart/{id}', [CartController::class, 'removeFromCart'])->name('customer.remove-from-cart');

// Route to show the form for updating a cart item
Route::get('/cart/update/{id}', [CartController::class, 'showUpdateForm'])->name('customer.update-cart');

// Route to handle the update request
Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('customer.update-cart.submit');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('customer.checkout');

Route::middleware(['auth:customer'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('customer.checkout');
    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('customer.process-checkout');
});

// Route for viewing all orders
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');

// Route for viewing a single order
Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');

// Route for editing a single order
Route::get('/admin/orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');

// Route for updating a single order
Route::put('/admin/orders/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update');

Route::get('/order-history', [OrderController::class, 'index'])->middleware('auth')->name('order.history');