<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CGPAService;
use App\Models\SubjectStatsLog;
use Illuminate\Support\Facades\DB;

class SubjectStatsLogController extends Controller
{
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

    private function validateData($request, $isEdit = false) {
        // Common validation rules
        $rules = [
            'subject_code' => 'required|string|max:7',
            'subject_name' => 'required|string|max:255',
            'subject_credit_hours' => 'required|integer|min:1|max:12',
            'subject_grade' => 'required|string|max:2',
        ];

        // For addSubject, validate 'sem_prog_log_id' also
        if (!$isEdit) {
            $rules['sem_prog_log_id'] = 'required|integer|exists:semester_progress_log,sem_prog_log_id';
        }

        // Validate the request
        return $request->validate($rules);
    }

    private function recalculateCGPAandSGPA($profile_id, $sem_prog_log_id) {
        $cgpaService = new CGPAService();
        $cgpa = $cgpaService->calculateCGPA($profile_id, $sem_prog_log_id);
        $sgpa = $cgpaService->calculateSGPA($sem_prog_log_id);

        return compact('cgpa', 'sgpa');
    }

    private function handleResponse($status, $sem_prog_log_id, $grades) {
        if ($status) {
            // Return JSON response for AJAX handling
            return response()->json([
                'success' => true,
                'cgpa' => $grades['cgpa'],
                'sgpa' => $grades['sgpa'],
                'subjects' => SubjectStatsLog::where('sem_prog_log_id', $sem_prog_log_id)->get()
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to add new subject. Please try again.']);
        }
    }

    // Add a new subject to a selected semester progress log
    public function addSubject(Request $request) {
        $validated = $this->validateData($request, false);
        
        try {
            // Create a new subject record
            $subject = new SubjectStatsLog();
            $subject->sem_prog_log_id = $validated['sem_prog_log_id'];
            $subject->subject_code = $validated['subject_code'];
            $subject->subject_name = $validated['subject_name'];
            $subject->subject_credit_hours = $validated['subject_credit_hours'];
            $subject->subject_grade = $validated['subject_grade'];
            $subject->subject_grade_point = $this->getGradePoint($subject->subject_grade) * $subject->subject_credit_hours;

            // Insert new record explicitly, ignore potential updates
            $status = DB::table('subject_stats_log')->insert([
                'sem_prog_log_id' => $subject->sem_prog_log_id,
                'subject_code' => $subject->subject_code,
                'subject_name' => $subject->subject_name,
                'subject_credit_hours' => $subject->subject_credit_hours,
                'subject_grade' => $subject->subject_grade,
                'subject_grade_point' => $subject->subject_grade_point,
            ]);

            // Recalculate CGPA and SGPA
            $grades = $this->recalculateCGPAandSGPA(profile()->profile_id, $validated['sem_prog_log_id']);

            return $this->handleResponse($status, $validated['sem_prog_log_id'], $grades);
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getSubjectData($sem_prog_log_id, $subject_code) {
        $subject = SubjectStatsLog::where('sem_prog_log_id', $sem_prog_log_id)
            ->where('subject_code', $subject_code)
            ->first();

        return response()->json($subject);
    }

    public function editSubject(Request $request, $sem_prog_log_id, $subject_code) {
        $validated = $this->validateData($request, true);

        try {
            // Manually updating each field
            $status = DB::table('subject_stats_log')
                ->where('sem_prog_log_id', $sem_prog_log_id)
                ->where('subject_code', $subject_code)
                ->update([
                    'subject_code' => $validated['subject_code'],
                    'subject_name' => $validated['subject_name'],
                    'subject_credit_hours' => $validated['subject_credit_hours'],
                    'subject_grade' => $validated['subject_grade'],
                    'subject_grade_point' => $this->getGradePoint($validated['subject_grade']) * $validated['subject_credit_hours'],
                ]);

            // Recalculate CGPA and SGPA
            $grades = $this->recalculateCGPAandSGPA(profile()->profile_id, $sem_prog_log_id);

            return $this->handleResponse($status, $sem_prog_log_id, $grades);
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deleteSubject($sem_prog_log_id, $subject_code) {
        try {
            // Manually deleting the row
            $status = DB::table('subject_stats_log')
                ->where('sem_prog_log_id', $sem_prog_log_id)
                ->where('subject_code', $subject_code)
                ->delete();

            // Recalculate CGPA and SGPA
            $grades = $this->recalculateCGPAandSGPA(profile()->profile_id, $sem_prog_log_id);

            return $this->handleResponse($status, $sem_prog_log_id, $grades);
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
