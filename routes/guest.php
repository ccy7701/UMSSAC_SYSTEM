<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\EmailVerificationController;
use App\Models\Account;
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

    Route::get('/email/verify', [EmailVerificationController::class, 'verify'])->name('verification.verify');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AccountController::class, 'login'])->name('account.login');
});
