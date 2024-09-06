<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SubjectStatsLog;

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

    // Add a new subject to a selected semester progress log
    public function addSubject(Request $request) {
        $validated = $request->validate([
            'sem_prog_log_id' => 'required|integer|exists:semester_progress_log,sem_prog_log_id', // Validate the selected semester ID
            'subject_code' => 'required|string|max:7',
            'subject_name' => 'required|string|max:255',
            'subject_credit_hours' => 'required|integer|min:1|max:4',
            'subject_grade' => 'required|string|max:2',
        ]);

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
            DB::table('subject_stats_log')->insert([
                'sem_prog_log_id' => $subject->sem_prog_log_id,
                'subject_code' => $subject->subject_code,
                'subject_name' => $subject->subject_name,
                'subject_credit_hours' => $subject->subject_credit_hours,
                'subject_grade' => $subject->subject_grade,
                'subject_grade_point' => $subject->subject_grade_point,
            ]);

            // return redirect()->back()->with('success', 'Subject added successfully!');
            return redirect()->route('profile')->with('success', 'Why are you here, though? (ADD_SUBJECT)');
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getSubjectData($sem_prog_log_id, $subject_code) {
        // dd($sem_prog_log_id, $subject_code);
        $subject = SubjectStatsLog::where('sem_prog_log_id', $sem_prog_log_id)
            ->where('subject_code', $subject_code)
            ->first();

        return response()->json($subject);
    }

    public function updateSubject(Request $request, $sem_prog_log_id, $subject_code) {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:7',
            'subject_name' => 'required|string|max:255',
            'subject_credit_hours' => 'required|string|min:1|max:4',
            'subject_grade' => 'required|string|max:2',
        ]);

        try {
            // Manually updating each field
            DB::table('subject_stats_log')
                ->where('sem_prog_log_id', $sem_prog_log_id)
                ->where('subject_code', $subject_code)
                ->update([
                    'subject_code' => $validated['subject_code'],
                    'subject_name' => $validated['subject_name'],
                    'subject_credit_hours' => $validated['subject_credit_hours'],
                    'subject_grade' => $validated['subject_grade'],
                    'subject_grade_point' => $this->getGradePoint($validated['subject_grade']) * $validated['subject_credit_hours'],
                ]);
    
            // return redirect()->back()->with('success', 'Subject added successfully!');
            return redirect()->route('profile')->with('success', 'Why are you here, though? (EDIT_SUBJECT)');
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
