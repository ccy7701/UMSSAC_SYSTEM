<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SemesterProgressLogController;
use App\Http\Controllers\SubjectStatsLogController;
use App\Http\Controllers\TimetableSlotController;
use App\Http\Middleware\RoleAccessMiddleware;
use App\Models\TimetableSlot;

// Routes accessible by student only (account role 1)
Route::middleware(['auth', RoleAccessMiddleware::class.':1'])->group(function () {
    Route::get('/progress-tracker/{profile_id?}', [SemesterProgressLogController::class, 'showProgressTracker'])->name('progress-tracker');

    Route::post('/progress-tracker/initialise/{profile_id}', [SemesterProgressLogController::class, 'initialiseProgressTracker'])->name('progress-tracker.initialise');

    Route::get('/fetch-subject-stats/{sem_prog_log_id?}', [SemesterProgressLogController::class, 'fetchSubjectStatsLogs'])->name('fetch-subject-stats');

    Route::get('/get-subject-data/{sem_prog_log_id}/{subject_code}', [SubjectStatsLogController::class, 'getSubjectData'])->name('subject-stats-log.get');

    Route::post('/add-subject', [SubjectStatsLogController::class, 'addSubject'])->name('subject-stats-log.add');

    Route::post('/edit-subject/{sem_prog_log_id}/{subject_code}', [SubjectStatsLogController::class, 'editSubject'])->name('subject-stats-log.edit');

    Route::delete('/delete-subject/{sem_prog_log_id}/{subject_code}', [SubjectStatsLogController::class, 'deleteSubject'])->name('subject-stats-log.delete');

    // CURRENT ROUTE OF FOCUS
    Route::get('/timetable-builder', function () {
        return view('timetable-builder.timetable-builder');
    })->name('timetable-builder');

    // CURRENT ROUTE OF FOCUS
    Route::get('/timetable-builder/initialise', [TimetableSlotController::class, 'initialiseTimetable'])->name('timetable-builder.initialise');

    // CURRENT ROUTE OF FOCUS
    Route::get('/get-timetable-slot-data/{profile_id}/{class_subject_code}', [TimetableSlotController::class, 'getTimetableSlotData'])->name('timetable-builder.get');

    // CURRENT ROUTE OF FOCUS
    Route::post('/timetable-builder/add', [TimetableSlotController::class, 'addTimetableSlot'])->name('timetable-builder.add');

    // CURRENT ROUTE OF FOCUS
    Route::post('/add-timetable-slot/{profile_id}/{class_subject_code}', [TimetableSlotController::class, 'editTimetableSlot'])->name('timetable-builder.edit');
});
