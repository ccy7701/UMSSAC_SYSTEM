<?php

namespace App\Services;

use App\Models\SubjectStatsLog;
use Illuminate\Support\Facades\Log;

class CGPAService
{
    // Get the grade point based on the letter grade
    public function getGradePoint($grade) {
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

    // Recalculate the CGPA and SGPA
    public function recalculateCGPAandSGPA($profileId, $semProgLogId) {
        $cgpa = $this->calculateCGPA($profileId, $semProgLogId);
        $sgpa = $this->calculateSGPA($semProgLogId);

        return compact('cgpa', 'sgpa');
    }

    // Calculate CGPA up until the selected semester
    public function calculateCGPA($profileId, $semProgLogId) {
        // Fetch all subject stats logs up to and including the selected semester
        $allSubjectStatsLogs = SubjectStatsLog::whereHas('semesterProgressLog', function($query) use ($profileId, $semProgLogId) {
            $query
                ->where('profile_id', $profileId)
                ->where('sem_prog_log_id', '<=', $semProgLogId);
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
    public function calculateSGPA($semProgLogId) {
        Log::info('SGPA Calculation - sem_prog_log_id:', ['sem_prog_log_id' => $semProgLogId]);  // Debug
    
        $currentSemesterSubjects = SubjectStatsLog::where('sem_prog_log_id', $semProgLogId)->get();
    
        Log::info('Subjects for SGPA Calculation:', $currentSemesterSubjects->toArray());  // Debug: Log the subjects fetched for the selected semester
    
        $totalSGPs = 0;
        $totalSemCredits = 0;
    
        foreach ($currentSemesterSubjects as $subject) {
            $gradePoint = $this->getGradePoint($subject->subject_grade);
            Log::info('Subject:', ['subject_code' => $subject->subject_code, 'grade' => $subject->subject_grade, 'grade_point' => $gradePoint, 'credit_hours' => $subject->subject_credit_hours]);  // Debug
    
            $totalSGPs += $gradePoint * $subject->subject_credit_hours;
            $totalSemCredits += $subject->subject_credit_hours;
        }
    
        $sgpa = $totalSemCredits > 0 ? $totalSGPs / $totalSemCredits : 0;
    
        Log::info('Calculated SGPA:', ['sgpa' => $sgpa, 'total_sem_credits' => $totalSemCredits, 'total_sgps' => $totalSGPs]);  // Debug: Log final calculated SGPA
    
        return $sgpa;
    }
}
