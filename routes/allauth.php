<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserPreferenceController;

// Routes accessible by all levels of authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.profile');
    })->name('profile');

    Route::get('/profile/edit-profile-picture', function () {
        return view('profile.edit.profile-picture');
    })->name('profile.edit.profile-picture');

    Route::post('/profile/edit-profile-picture/action', [ProfileController::class, 'updateProfilePicture'])->name('profile.edit.profile-picture.action');

    Route::get('/profile/edit-general-info', function () {
        return view('profile.edit.general-info');
    })->name('profile.edit.general-info');

    Route::post('/profile/edit-general-info/action', [ProfileController::class, 'updateGeneralInfo'])->name('profile.edit.general-info.action');

    Route::get('/change-password', function () {
        return view('auth.passwords.change-password');
    })->name('change-password');

    Route::post('/change-password/action', [PasswordResetController::class, 'changePassword'])->name('change-password.action');

    Route::get('/events-finder', [EventController::class, 'fetchEventsFinder'])->name('events-finder');

    Route::post('/events-finder/filter', [EventController::class, 'fetchEventsFinder'])->name('events-finder.filter');

    Route::post('/events-finder/clear-all', [EventController::class, 'clearFilterForGeneral'])->name('events-finder.clear-filter');

    Route::get('/events-finder/full-details', [EventController::class, 'fetchEventDetails'])->name('events-finder.fetch-event-details');

    Route::get('/events-finder/bookmarks', function () {
        return view('events-finder.bookmarks');
    })->name('events-finder.bookmarks');

    // CURRENT ROUTE OF FOCUS
    Route::post('/events-finder/bookmarks/toggle', [EventController::class, 'toggleEventBookmark'])->name('events-finder.bookmarks.toggle');
    
    Route::post('/update-search-view-preference', [UserPreferenceController::class, 'updateItemViewPreference']);

    Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');
});
