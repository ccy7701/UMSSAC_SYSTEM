<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleAccessMiddleware;
use App\Http\Controllers\ClubController;

// Routes accessible by faculty member only (account role 2)
Route::middleware(['auth', RoleAccessMiddleware::class.':2'])->group(function () {
    // CURRENT ROUTE IN FOCUS
    Route::get('/create-new-club/request', function () {
        return view('clubs-finder.create-new-club-request');
    })->name('create-new-club.request');

    // CURRENT ROUTE IN FOCUS
    Route::get('/club/send-email-test', [ClubController::class, 'sendEmailTest'])->name('send-email-test');
});
