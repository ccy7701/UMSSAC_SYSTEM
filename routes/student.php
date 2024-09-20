<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SemesterProgressLogController;
use App\Http\Controllers\SubjectStatsLogController;
use App\Http\Controllers\TimetableSlotController;
use App\Http\Middleware\RoleAccessMiddleware;

// Routes accessible by student only (account role 1)
Route::middleware(['auth', RoleAccessMiddleware::class.':1'])->group(function () {
    Route::get('/progress-tracker/{profile_id?}', [SemesterProgressLogController::class, 'showProgressTracker'])->name('progress-tracker');

    Route::post('/progress-tracker/initialise/{profile_id}', [SemesterProgressLogController::class, 'initialiseProgressTracker'])->name('progress-tracker.initialise');

    Route::get('/fetch-subject-stats/{sem_prog_log_id}', [SemesterProgressLogController::class, 'fetchSubjectStatsLogs'])->name('fetch-subject-stats');

    Route::get('/get-subject-data/{sem_prog_log_id}/{subject_code}', [SubjectStatsLogController::class, 'getSubjectData'])->name('subject-stats-log.get');

    Route::post('/add-subject', [SubjectStatsLogController::class, 'addSubject'])->name('subject-stats-log.add');

    Route::post('/edit-subject/{sem_prog_log_id}/{subject_code}', [SubjectStatsLogController::class, 'editSubject'])->name('subject-stats-log.edit');

    Route::delete('/delete-subject/{sem_prog_log_id}/{subject_code}', [SubjectStatsLogController::class, 'deleteSubject'])->name('subject-stats-log.delete');
    
    Route::get('/timetable-builder', function () {
        return view('timetable-builder.timetable-builder');
    })->name('timetable-builder');

    Route::get('/timetable-builder/initialise', [TimetableSlotController::class, 'initialiseTimetable'])->name('timetable-builder.initialise');

    Route::get('/get-timetable-slot-data/{timetable_slot_id}', [TimetableSlotController::class, 'getTimetableSlotData'])->name('timetable-builder.get');

    Route::get('/get-slots-by-day/{profile_id}/{class_day}/{exclude_slot_id?}', [TimetableSlotController::class, 'getSlotsByDay'])->name('timetable-builder.get-slots-by-day');

    Route::post('/timetable-builder/add', [TimetableSlotController::class, 'addTimetableSlot'])->name('timetable-builder.add');

    Route::post('/edit-timetable-slot/{timetable_slot_id}', [TimetableSlotController::class, 'editTimetableSlot'])->name('timetable-builder.edit');

    Route::delete('/delete-timetable-slot/{timetable_slot_id}', [TimetableSlotController::class, 'deleteTimetableSlot'])->name('timetable-builder.delete');
});
