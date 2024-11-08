<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleAccessMiddleware;
use App\Http\Controllers\ClubCreationController;

// Routes accessible by faculty member only (account role 2)
Route::middleware(['auth', RoleAccessMiddleware::class.':2'])->group(function () {
    // CURRENT ROUTE IN FOCUS
    Route::get('/club-creation/requests/new', function () {
        return view('clubs-finder.general.create-new-club-request');
    })->name('club-creation.requests.new');

    // CURRENT ROUTE IN FOCUS
    Route::post('/club-creation/requests/new/action', [ClubCreationController::class, 'makeNewClubCreationRequest'])->name('club-creation.requests.new.action');

    // CURRENT ROUTE IN FOCUS
    Route::get('/club-creation/requests/view', [ClubCreationController::class, 'fetchRequestsPage'])->name('club-creation.requests.view');
});
