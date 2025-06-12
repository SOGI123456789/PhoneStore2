<?php

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
});

