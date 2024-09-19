<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Services\CGPAService;
use App\Models\SubjectStatsLog;
use App\Models\SemesterProgressLog;

class SemesterProgressLogController extends Controller
{
    // Create new SemesterProgressLogs based on the details pushed to this function
    public function initialiseProgressTracker(Request $request, $profile_id = null) {
        // Check if profile_id is provided; otherwise, get the profile_id of the logged-in student
        $profile_id = $profile_id ?? profile()->profile_id;

        // Retrieve the profile instance of the user
        $profile = Profile::find($profile_id);

        // Update profile_enrolment_session with the user's input
        $profile->profile_enrolment_session = $request->input('profile_enrolment_session');
        $profile->save();

        // Extract user input for the enrolment session and course duration
        $enrolmentSession = $request->input('profile_enrolment_session');
        $courseDuration = $request->input('course_duration');

        // Split the enrolment session to extract the starting year
        $sessionParts = explode('/', $enrolmentSession);
        $startYear = intval($sessionParts[0]);

        // Create SemesterProgressLogs for each semester in the course duration
        for ($semesterCount = 0; $semesterCount < $courseDuration; $semesterCount++) {
            // Calculate the academic session for the current semester
            $academicYear = $startYear + intdiv($semesterCount, 2);
            $academicSession = $academicYear .'/'. ($academicYear + 1);

            // Determine whether it is semester 1 or 2 for the academic year
            $semester = ($semesterCount % 2) + 1;

            // Create the SemesterProgressLog entry
            $status = SemesterProgressLog::create([
                'profile_id' => $profile_id,
                'semester' => $semester,
                'academic_session' => $academicSession,
            ]);
        }

        // Redirect back to the page with a success message
        return $status
            ? redirect()->route('progress-tracker')->with('success', 'Progress tracker set up successfully. Feel free to use it now!')
            : back()->withErrors(['progress-tracker' => 'Failed to initialise progress tracker. Please try again.']);
    }

    // Fetch the necessary data from the semester_progress_log
    public function showProgressTracker($profile_id = null) {
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
        $semesterProgressLog = SemesterProgressLog::where('sem_prog_log_id', $sem_prog_log_id)->first();
        $subjectStatsLog = SubjectStatsLog::where('sem_prog_log_id', $sem_prog_log_id)->get();
    
        // Calculate CGPA and SGPA for this semester
        $cgpaService = new CGPAService();
        $cgpa = $cgpaService->calculateCGPA(profile()->profile_id, $sem_prog_log_id);
        $sgpa = $cgpaService->calculateSGPA($sem_prog_log_id);
    
        // Return both the subject data and CGPA/SGPA values
        return response()->json([
            'semester' => $semesterProgressLog ? $semesterProgressLog->semester : null,
            'academic_session' => $semesterProgressLog ? $semesterProgressLog->academic_session : null,
            'subjects' => $subjectStatsLog,
            'cgpa' => $cgpa,
            'sgpa' => $sgpa,
        ]);
    }
}
