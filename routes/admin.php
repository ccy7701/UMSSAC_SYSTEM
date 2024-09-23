<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ClubMembershipController;
use App\Http\Middleware\RoleAccessMiddleware;

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

    // CURRENT ROUTE OF FOCUS
    Route::get('/all-system-users', [AccountController::class, 'fetchAllSystemUsers'])->name('admin.all-system-users');

    // CURRENT ROUTE OF FOCUS
    Route::post('/all-system-users/filter', [AccountController::class, 'fetchAllSystemUsers'])->name('admin.all-system-users.filter');

    // CURRENT ROUTE OF FOCUS
    Route::post('/all-system-users/clear-all', [AccountController::class, 'clearFilters'])->name('admin.all-system-users.clear-filter');
});
