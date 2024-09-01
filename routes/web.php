<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordResetController;
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

    // The forgot password form
    Route::get('/forgot-password', function () {
        return view('forgot-password');
    })->name('forgot-password');

    // Send the password reset link to the user's email address
    Route::post('/forgot-password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

    // Show the reset password form (user clicks the link in their email)
    Route::get('/forgot-password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');

    // Handle the reset password form submission (user submits their new password)
    Route::post('/forgot-password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
});

// Routes accessible to all levels of authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/profile', function() {
        return view('profile.profile');
    })->name('profile');

    Route::get('/profile/edit-profile-picture', function() {
        return view('profile.edit-profile-picture');
    })->name('profile.edit-profile-picture');

    Route::get('/profile/edit-general-info', function() {
        return view('profile.edit-general-info');
    })->name('profile.edit-general-info');

    Route::get('/reset-password', function () {
        return view('profile.reset-password');
    })->name('reset-password');

    Route::post('/profile/edit-profile-picture-action', [ProfileController::class, 'updateProfilePicture'])->name('profile.edit-profile-picture-action');

    Route::post('/profile/edit-general-info-action', [ProfileController::class, 'updateGeneralInfo'])->name('profile.edit-general-info-action');

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