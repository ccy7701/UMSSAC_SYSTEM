<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
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

    Route::get('/reset-password', function () {
        return view('reset-password');
    })->name('reset-password');
});

// Routes accessible to all levels of authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/profile', function() {
        return view('profile.profile');
    })->name('profile');

    Route::get('/profile/edit-profile-picture', function() {
        return view('profile.edit-profile-picture');
    })->name('profile.edit-profile-picture');

    Route::get('/profile/edit-general', function() {
        return view('profile.edit-general');
    })->name('profile.edit-general');

    Route::post('/profile/edit-profile-picture-action', [ProfileController::class, 'updateProfilePicture'])->name('profile.edit-profile-picture-action');

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