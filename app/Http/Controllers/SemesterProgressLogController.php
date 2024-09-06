<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SemesterProgressLog;
use App\Models\SubjectStatsLog; // KIV

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
            $cgpa = $this->calculateCGPA($profile_id, $latest_semester->sem_prog_log_id);
            $sgpa = $this->calculateSGPA($latest_semester->sem_prog_log_id);
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
        $cgpa = $this->calculateCGPA(profile()->profile_id, $sem_prog_log_id);
        $sgpa = $this->calculateSGPA($sem_prog_log_id);
    
        // Return both the subject data and CGPA/SGPA values
        return response()->json([
            'subjects' => $subjectStatsLog,
            'cgpa' => $cgpa,
            'sgpa' => $sgpa
        ]);
    }
    
    // Get the grade point based on the letter grade
    private function getGradePoint($grade) {
        $gradePoints = [
            'A' => 4.00,
            'A+' => 4.00,   // Cohorts 2022/2023 and beyond only
            'A-' => 3.67,
            'B+' => 3.33,
            'B' => 3.00,
            'B-' => 2.67,
            'C+' => 2.33,
            'C' => 2.00,
            'C-' => 1.67,
            'D+' => 1.33,
            'D' => 1.00,
            'E' => 0.00,
            'X' => 0.00
        ];
    
        return $gradePoints[$grade] ?? 0.00;
    }
    
    // Calculate CGPA up until the selected semester
    private function calculateCGPA($profile_id, $sem_prog_log_id) {
        // Fetch all subject stats logs up to and including the selected semester
        $allSubjectStatsLogs = SubjectStatsLog::whereHas('semesterProgressLog', function($query) use ($profile_id, $sem_prog_log_id) {
            $query
                ->where('profile_id', $profile_id)
                ->where('sem_prog_log_id', '<=', $sem_prog_log_id);
        })->get();
    
        $totalCGPs = 0;     // Total cumulative grade points
        $totalCredits = 0;
    
        foreach($allSubjectStatsLogs as $subject) {
            $gradePoint = $this->getGradePoint($subject->subject_grade);
            $totalCGPs += $gradePoint * $subject->subject_credit_hours;
            $totalCredits += $subject->subject_credit_hours;
        }
        
        return $totalCredits > 0 ? $totalCGPs / $totalCredits : 0;
    }
    
    // Calculate SGPA for the selected semester
    private function calculateSGPA($sem_prog_log_id) {
        // Fetch only subject stats logs for the selected semester
        $currentSemesterSubjects = SubjectStatsLog::where('sem_prog_log_id', $sem_prog_log_id)->get();
    
        $totalSGPs = 0;
        $totalSemCredits = 0;
    
        foreach($currentSemesterSubjects as $subject) {
            $gradePoint = $this->getGradePoint($subject->subject_grade);
            $totalSGPs += $gradePoint * $subject->subject_credit_hours;
            $totalSemCredits += $subject->subject_credit_hours;
        }
    
        return $totalSemCredits > 0 ? $totalSGPs / $totalSemCredits : 0;
    }
}
