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

    // CURRENT ROUTE OF FOCUS
    Route::get('/events-finder/full-details/manage', [EventController::class, 'fetchEventManagePage'])->name('events-finder.manage-details');
    
    Route::post('/update-search-view-preference', [UserPreferenceController::class, 'updateItemViewPreference']);

    Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');
});

// Routes accessible by student only (account role 1)
Route::middleware(['auth', RoleAccessMiddleware::class.':1'])->group(function () {
    Route::get('/progress-tracker/{profile_id?}', [SemesterProgressLogController::class, 'showProgressTracker'])->name('progress-tracker');

    Route::post('/progress-tracker/initialise/{profile_id}', [SemesterProgressLogController::class, 'initialiseProgressTracker'])->name('progress-tracker.initialise');

    Route::get('/fetch-subject-stats/{sem_prog_log_id?}', [SemesterProgressLogController::class, 'fetchSubjectStatsLogs'])->name('fetch-subject-stats');

    Route::get('/get-subject-data/{sem_prog_log_id}/{subject_code}', [SubjectStatsLogController::class, 'getSubjectData'])->name('subject-stats-log.get');

    Route::post('/add-subject', [SubjectStatsLogController::class, 'addSubject'])->name('subject-stats-log.add');

    Route::post('/edit-subject/{sem_prog_log_id}/{subject_code}', [SubjectStatsLogController::class, 'editSubject'])->name('subject-stats-log.edit');

    Route::delete('/delete-subject/{sem_prog_log_id}/{subject_code}', [SubjectStatsLogController::class, 'deleteSubject'])->name('subject-stats-log.delete');
});

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
