<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home'); // dòng 8-9 có ý nghĩa là khi nhập vào direct link /home thì nó sẽ load view home.blade.php
});
Route::prefix('categories')->group(function () {
    Route::get('/create', [
        'as'=>'categories.create',
        'uses'=>'App\Http\Controllers\CategoryController@create'
    ]);
    Route::get('/', [
        'as'=>'categories.index',
        'uses'=>'App\Http\Controllers\CategoryController@index'
    ]);
    Route::post('/store', [
        'as'=>'categories.store',                               // phương thức thêm danh mục sản phẩm
        'uses'=>'App\Http\Controllers\CategoryController@store'
    ]);
});
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return view('index');
})->name('index');
