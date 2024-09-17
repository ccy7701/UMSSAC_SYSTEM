<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ClubMembershipController;
use App\Http\Middleware\RoleAccessMiddleware;
use App\Http\Middleware\CommitteeAccessMiddleware;

require_once __DIR__.'/guest.php';
require_once __DIR__.'/allauth.php';
require_once __DIR__.'/admin.php';
require_once __DIR__.'/student.php';

// Routes accessible by facultyMember only (account role 2)
// Route::middleware(['auth', RoleAccessMiddleware::class.':2'])->group(function ())

// Routes accessible by both student and facultyMember (account role 1 and 2)
Route::middleware(['auth', RoleAccessMiddleware::class.':1,2'])->group(function () {
    Route::get('/clubs-finder', [ClubController::class, 'fetchClubsFinder'])->name('clubs-finder');

    Route::post('/clubs-finder/filter', [ClubController::class, 'fetchClubsFinder'])->name('clubs-finder.filter');

    Route::post('/clubs-finder/clear-all', [ClubController::class, 'clearFilterForGeneral'])->name('clubs-finder.clear-filter');

    Route::get('/clubs-finder/full-details', [ClubController::class, 'fetchClubDetailsForGeneral'])->name('clubs-finder.fetch-club-details');

    Route::post('/clubs-finder/join-club', [ClubMembershipController::class, 'joinClub'])->name('clubs-finder.join-club');

    Route::post('/clubs-finder/leave-club', [ClubMembershipController::class, 'leaveClub'])->name('clubs-finder.leave-club');

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

        // CURRENT ROUTE OF FOCUS
        Route::get('/events-finder/full-details/manage', [EventController::class, 'fetchEventManagePage'])->name('events-finder.manage-details');

        Route::get('/events-finder/full-details/manage/edit-images', [EventController::class, 'showEventImagesEdit'])->name('event-manage.edit-images');

        Route::post('/events-finder/full-details/manage/edit-images/add', [EventController::class, 'addEventImage'])->name('event-manage.edit-images.add');

        Route::post('/events-finder/full-details/manage/edit-images/delete', [EventController::class, 'deleteEventImage'])->name('event-manage.edit-images.delete');

        // CURRENT ROUTE OF FOCUS
        Route::get('/events-finder/full-details/manage/edit-event-info', [EventController::class, 'showEventInfoEdit'])->name('event-manage.edit-event-info');

        // CURRENT ROUTE OF FOCUS
        Route::post('/events-finder/full-details/manage/edit-event-info/action', [EventController::class, 'updateEventInfo'])->name('event-manage.edit-event-info.action');

        // CURRENT ROUTE OF FOCUS
        Route::post('/events-finder/full-details/manage/delete-event', [EventController::class, 'deleteEvent'])->name('event-manage.delete-event');
    });
});
