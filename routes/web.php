<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\SemesterProgressLogController;
use App\Http\Controllers\SubjectStatsLogController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\UserPreferenceController;
use App\Http\Controllers\ClubMembershipController;
use App\Http\Middleware\PreventAuthenticatedAccess;
use App\Http\Middleware\RoleAccessMiddleware;
use App\Http\Middleware\CommitteeAccessMiddleware;

require __DIR__.'/guest.php';
require __DIR__.'/allauth.php';
require __DIR__.'/student.php';

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
    });
});

// Routes accessible by admin only (account role 3)
Route::middleware(['auth', RoleAccessMiddleware::class.':3'])->group(function () {
    Route::get('/manage-clubs', [ClubController::class, 'fetchClubsManager'])->name('manage-clubs');

    Route::post('/manage-clubs/filter', [ClubController::class, 'fetchClubsManager'])->name('manage-clubs.filter');

    Route::post('/manage-clubs/clear-all', [ClubController::class, 'clearFilterForManager'])->name('manage-clubs.clear-filter');

    Route::get('/manage-clubs/full-details', [ClubController::class, 'fetchClubDetailsForManager'])->name('manage-clubs.fetch-club-details');

    Route::get('/admin-manage/full-details/manage', [ClubController::class, 'fetchAdminManagePage'])->name('admin-manage.manage-details');

    Route::get('/admin-manage/full-details/manage/edit-club-info', [ClubController::class, 'showClubInfoEditForAdmin'])->name('admin-manage.edit-club-info');

    Route::post('/admin-manage/full-details/manage/edit-club-info/action', [ClubController::class, 'updateClubInfo'])->name('admin-manage.edit-club-info.action');

    Route::get('/admin-manage/full-details/manage/edit-images', [ClubController::class, 'showClubImagesEditForAdmin'])->name('admin-manage.edit-images');

    Route::post('/admin-manage/full-details/manage/edit-images/add', [ClubController::class, 'addClubImage'])->name('admin-manage.edit-images.add');

    Route::post('/admin-manage/full-details/manage/edit-images/delete', [ClubController::class, 'deleteClubImage'])->name('admin-manage.edit-images.delete');

    Route::get('/admin-manage/full-details/manage/edit-members-access', [ClubMembershipController::class, 'showClubMembersForAdmin'])->name('admin-manage.edit-member-access');

    Route::post('/admin-manage/full-details/manage/edit-members-access/action', [ClubMembershipController::class, 'updateClubMemberAccess'])->name('admin-manage.edit-member-access.action');

    Route::get('/manage-clubs/add-new-club', function () {
        return view('clubs-finder.admin-manage.add-new-club');
    })->name('manage-clubs.add-new-club');

    Route::post('manage-clubs/add-new-club/action', [ClubController::class, 'addNewClub'])->name('manage-clubs.add-new-club.action');
});
