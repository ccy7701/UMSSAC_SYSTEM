<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Middleware\PreventAuthenticatedAccess;

// Routes accessible by guests but not authenticated users
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
        return view('auth.register');
    })->name('register');

    Route::post('/register', [AccountController::class, 'register'])->name('account.register');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AccountController::class, 'login'])->name('account.login');

    // The forgot password form
    Route::get('/forgot-password', function () {
        return view('auth.passwords.forgot-password');
    })->name('forgot-password');

    // Send the password reset link to the user's email address
    Route::post('/forgot-password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

    // Show the reset password form (user clicks the link in their email)
    Route::get('/forgot-password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');

    // Handle the reset password form submission (user submits their new password)
    Route::post('/forgot-password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
});
