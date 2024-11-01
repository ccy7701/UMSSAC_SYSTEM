<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ClubMembershipController;
use App\Http\Middleware\RoleAccessMiddleware;
use App\Http\Middleware\CommitteeAccessMiddleware;
use App\Http\Controllers\Auth\PasswordResetController;

require __DIR__.'/guest.php';
require __DIR__.'/allauth.php';
require __DIR__.'/admin.php';
require __DIR__.'/student.php';

// Routes accessible by users regardless of access level

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

// Routes accessible by both student and facultyMember (account role 1 and 2)
Route::middleware(['auth', RoleAccessMiddleware::class.':1,2'])->group(function () {
    /*
    * CLUBS FINDER MODULE ROUTES
    */
    Route::get('/clubs-finder', [ClubController::class, 'fetchClubsFinder'])->name('clubs-finder');

    Route::post('/clubs-finder/filter', [ClubController::class, 'fetchClubsFinder'])->name('clubs-finder.filter');

    Route::post('/clubs-finder/clear-all', [ClubController::class, 'clearFilterForGeneral'])->name('clubs-finder.clear-filter');

    Route::get('/clubs-finder/full-details', [ClubController::class, 'fetchClubDetailsForGeneral'])->name('clubs-finder.fetch-club-details');

    Route::post('/clubs-finder/join-club', [ClubMembershipController::class, 'joinClub'])->name('clubs-finder.join-club');

    Route::post('/clubs-finder/leave-club', [ClubMembershipController::class, 'leaveClub'])->name('clubs-finder.leave-club');

    Route::get('/clubs-finder/joined-clubs', [ClubController::class, 'fetchJoinedClubs'])->name('clubs-finder.joined-clubs');

    /*
    * EVENTS FINDER MODULE ROUTES
    */
    Route::get('/events-finder/bookmarks', [EventController::class, 'fetchUserEventBookmarks'])->name('events-finder.bookmarks');

    Route::post('/events-finder/bookmarks/toggle', [EventController::class, 'toggleEventBookmark'])->name('events-finder.bookmarks.toggle');

    Route::middleware(CommitteeAccessMiddleware::class)->group(function () {
        Route::get('/committee-manage/full-details/manage', [ClubController::class, 'fetchCommitteeManagePage'])
            ->name('committee-manage.manage-details');

        Route::get('/committee-manage/full-details/manage/edit-club-info', [ClubController::class, 'showClubInfoEditForCommittee'])->name('committee-manage.edit-club-info');

        Route::post('/committee-manage/full-details/manage/edit-club-info/action', [ClubController::class, 'updateClubInfo'])->name('committee-manage.edit-club-info.action');

        Route::get('/committee-manage/full-details/manage/edit-images', [ClubController::class, 'showClubImagesEditForCommittee'])->name('committee-manage.edit-images');

        Route::post('/committee-manage/full-details/manage/edit-images/add', [ClubController::class, 'addClubImage'])->name('committee-manage.edit-images.add');

        Route::post('/committee-manage/full-details/manage/edit-images/delete', [ClubController::class, 'deleteClubImage'])->name('committee-manage.edit-images.delete');

        Route::get('/committee-manage/full-details/manage/edit-members-access', [ClubMembershipController::class, 'showClubMembersForCommittee'])->name('committee-manage.edit-member-access');

        Route::post('/committee-manage/full-details/manage/edit-members-access/action', [ClubMembershipController::class, 'updateClubMemberAccess'])->name('committee-manage.edit-member-access.action');

        Route::get('/events-finder/full-details/manage', [EventController::class, 'fetchEventManagePage'])->name('events-finder.manage-details');

        Route::get('/events-finder/full-details/manage/edit-images', [EventController::class, 'showEventImagesEdit'])->name('event-manage.edit-images');

        Route::post('/events-finder/full-details/manage/edit-images/add', [EventController::class, 'addEventImage'])->name('event-manage.edit-images.add');

        Route::post('/events-finder/full-details/manage/edit-images/delete', [EventController::class, 'deleteEventImage'])->name('event-manage.edit-images.delete');

        Route::get('/events-finder/full-details/manage/edit-event-info', [EventController::class, 'showEventInfoEdit'])->name('event-manage.edit-event-info');

        Route::post('/events-finder/full-details/manage/edit-event-info/action', [EventController::class, 'updateEventInfo'])->name('event-manage.edit-event-info.action');

        Route::get('/events-finder/add-new-event', [EventController::class, 'showAddEventForm'])->name('event-manage.add-new-event');

        Route::post('/events-finder/add-new-event/action', [EventController::class, 'addNewEvent'])->name('event-manage.add-new-event.action');

        Route::post('/events-finder/full-details/manage/delete-event', [EventController::class, 'deleteEvent'])->name('event-manage.delete-event');
    });
});
