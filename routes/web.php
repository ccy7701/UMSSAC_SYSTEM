<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/features', function () {
    return view('features');
});