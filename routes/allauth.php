<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserPreferenceController;

// Routes accessible by all levels of authenticated user
Route::middleware('auth')->group(function () {
    /*
    * PROFILE MANAGEMENT RELATED ROUTES
    */
    Route::get('/my-profile/dev', function () {
        return view('profile.my-profile-dev');
    })->name('my-profile.dev');

    Route::get('/my-profile', function () {
        return view('profile.my-profile');
    })->name('my-profile');

    Route::get('/my-profile/edit-profile-picture', function () {
        return view('profile.edit.profile-picture');
    })->name('profile.edit.profile-picture');

    Route::post('/my-profile/edit-profile-picture/action', [ProfileController::class, 'updateProfilePicture'])->name('profile.edit.profile-picture.action');

    Route::get('/my-profile/edit-general-info', function () {
        return view('profile.edit.general-info');
    })->name('profile.edit.general-info');

    Route::post('/my-profile/edit-general-info/action', [ProfileController::class, 'updateGeneralInfo'])->name('profile.edit.general-info.action');

    Route::get('/change-password', function () {
        return view('auth.passwords.change-password');
    })->name('change-password');

    Route::post('/change-password/action', [PasswordResetController::class, 'changePassword'])->name('change-password.action');

    Route::get('/view-user-profile', [ProfileController::class, 'fetchUserProfile'])->name('view-user-profile');

    /*
    * EVENTS FINDER RELATED ROUTES
    */
    Route::get('/events-finder', [EventController::class, 'fetchEventsFinder'])->name('events-finder');

    Route::post('/events-finder/filter', [EventController::class, 'fetchEventsFinder'])->name('events-finder.filter');

    Route::post('/events-finder/clear-all', [EventController::class, 'clearFilterForGeneral'])->name('events-finder.clear-filter');

    Route::get('/events-finder/full-details', [EventController::class, 'fetchEventDetails'])->name('events-finder.fetch-event-details');
    
    Route::post('/update-search-view-preference', [UserPreferenceController::class, 'updateItemViewPreference']);

    Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');
});
