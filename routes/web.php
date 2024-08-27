<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\PreventAuthenticatedAccess;
use App\Http\Middleware\RoleAccessMiddleware;

// Routes accessible to guests but not authenticated users
Route::middleware([PreventAuthenticatedAccess::class])->group(function () {
    Route::get('/', function () {
        return redirect('welcome');
    });

    Route::get('/welcome', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/features', function () {
        return view('features');
    })->name('features');

    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::post('/register', [AccountController::class, 'register'])->name('account.register');

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [AccountController::class, 'login'])->name('account.login');

    Route::get('/reset_password', function () {
        return view('reset_password');
    })->name('reset_password');
});

// Routes accessible to all levels of authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/profile', function() {
        return view('profile.profile');
    })->name('profile');

    Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');
});

// Routes accessible to accountRole -> Student only
Route::middleware(['auth', RoleAccessMiddleware::class.':1'])->group(function () {
    Route::get('/test', function () {
        return view('test');
    })->name('test');
});

// Routes accessible to accountRole -> FacultyMember only
Route::middleware(['auth', RoleAccessMiddleware::class.':2'])->group(function () {

});

// Routes accessible to accountRole -> Admin only
Route::middleware(['auth', RoleAccessMiddleware::class.':3'])->group(function () {

});