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
