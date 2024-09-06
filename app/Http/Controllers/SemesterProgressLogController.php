<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SemesterProgressLog;
use App\Models\SubjectStatsLog;
use App\Services\CGPAService;

class SemesterProgressLogController extends Controller
{
    // Fetch the necessary data from the semester_progress_log
    public function showProgressTracker($profile_id = null) {
        // Check if profile_id is provided; otherwise, get the profile_id of the logged-in student
        $profile_id = $profile_id ?? profile()->profile_id;
    
        // Fetch all available semesters for the dropdown
        $all_semesters = SemesterProgressLog::where('profile_id', $profile_id)->get();
    
        // Fetch the latest semester's subject data to calculate CGPA/SGPA
        $latest_semester = SemesterProgressLog::where('profile_id', $profile_id)->orderBy('sem_prog_log_id', 'desc')->first();
    
        if ($latest_semester) {
            $cgpaService = new CGPAService();
            $cgpa = $cgpaService->calculateCGPA($profile_id, $latest_semester->sem_prog_log_id);
            $sgpa = $cgpaService->calculateSGPA($latest_semester->sem_prog_log_id);
        } else {
            $cgpa = 0.00;
            $sgpa = 0.00;
        }
    
        // Pass the fetched data to the view
        return view('acad-progress.progress-tracker', compact('all_semesters', 'cgpa', 'sgpa'));
    }
    
    // Fetch and display the subjects based on the selected semester
    // KIV
    public function fetchSubjectStatsLogs($sem_prog_log_id) {
        $subjectStatsLog = SubjectStatsLog::where('sem_prog_log_id', $sem_prog_log_id)->get();
    
        // Calculate CGPA and SGPA for this semester
        $cgpaService = new CGPAService();
        $cgpa = $cgpaService->calculateCGPA(profile()->profile_id, $sem_prog_log_id);
        $sgpa = $cgpaService->calculateSGPA($sem_prog_log_id);
    
        // Return both the subject data and CGPA/SGPA values
        return response()->json([
            'subjects' => $subjectStatsLog,
            'cgpa' => $cgpa,
            'sgpa' => $sgpa
        ]);
    }
}
