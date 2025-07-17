<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/index', [HomeController::class, 'showIndex'])->name('index');

// Shopping cart route
Route::get('/shopping-cart', [CartController::class, 'index'])->name('shopping-cart');

// Cart routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('/add', [CartController::class, 'addToCart'])->name('add');
    Route::post('/update', [CartController::class, 'updateCart'])->name('update');
    Route::post('/remove', [CartController::class, 'removeFromCart'])->name('remove');
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
});

// Checkout route
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');

// Order routes (for customers)
Route::prefix('orders')->name('orders.')->group(function () {
    Route::post('/create', [OrderController::class, 'createOrder'])->name('create');
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [OrderController::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [OrderController::class, 'update'])->name('update');
    Route::post('/{id}/status', [OrderController::class, 'updateStatus'])->name('update-status');
    Route::post('/{id}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('update-payment-status');
});

// Place order routes
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place-order');
Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
Route::get('/order/success/{id}', [OrderController::class, 'orderSuccess'])->name('order.success');

// Admin Order routes  
Route::prefix('admin/orders')->name('admin.orders.')->group(function () {
    Route::get('/', [OrderController::class, 'adminIndex'])->name('index');
    Route::get('/{id}', [OrderController::class, 'adminShow'])->name('show');
    Route::put('/{id}/status', [OrderController::class, 'updateStatus'])->name('update-status');
    Route::delete('/{id}', [OrderController::class, 'delete'])->name('delete');
});

//  CATEGORIES ROUTES
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
    Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
    Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
});

//  MENUS ROUTES
Route::prefix('menus')->name('menus.')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('index'); // ← Đây là chuẩn
    Route::get('/create', [MenuController::class, 'create'])->name('create');
    Route::post('/store', [MenuController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('edit');
    Route::delete('/delete/{id}', [MenuController::class, 'delete'])->name('delete');
    Route::post('/update/{id}', [MenuController::class, 'update'])->name('update');
    
});


//  AUTH ROUTES
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
//  PRODUCT ROUTES
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit');
    Route::post('/update/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/delete/{product}', [ProductController::class, 'delete'])->name('delete');
});

//  ROLES ROUTES
Route::prefix('roles')->name('roles.')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
});

// Customer routes với middleware auth
Route::prefix('customer')->name('customer.')->middleware('auth')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::post('/update', [CustomerController::class, 'update'])->name('update');
});

Route::get('/', function () {
    return redirect()->route('index');
});
// Product detail route
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/category/{id}', [App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');
