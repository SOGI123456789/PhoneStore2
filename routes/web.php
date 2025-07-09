<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/home', function () {
    return view('home');
})->name('home');

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
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

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
