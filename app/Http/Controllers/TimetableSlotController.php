<?php

namespace App\Http\Controllers;

use App\Models\TimetableSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableSlotController extends Controller
{
    public function initialiseTimetable() {
        $timetableSlots = TimetableSlot::where('profile_id', profile()->profile_id)
            ->orderBy('class_day')
            ->get();

        return response()->json([
            'success' => true,
            'timetableSlots' => $timetableSlots
        ]);
    }

    public function getTimetableSlotData($profile_id, $class_subject_code) {
        $timetableSlot = TimetableSlot::where('profile_id', $profile_id)
            ->where('class_subject_code', $class_subject_code)
            ->first();

        return response()->json($timetableSlot);
    }

    public function addTimetableSlot(Request $request) {
        $validatedData = $request->validate([
            'profile_id' => 'required|integer|exists:profile,profile_id',
            'class_subject_code' => 'required|string|max:12',
            'class_name' => 'required|string|max:255',
            'class_category' => 'required|string|in:lecture,labprac,tutorial,cocurricular',
            'class_section' => 'required|integer|min:1',
            'class_location' => 'required|string|max:255',
            'class_day' => 'required|integer|between:1,7',
            'class_start_time' => 'required|date_format:H:i:s',
            'class_end_time' => 'required|date_format:H:i:s|after:class_start_time',
        ]);

        try {
            $status = DB::table('timetable_slot')->insert($validatedData);

            if ($status) {
                return response()->json([
                    'success' => true,
                    'timetableSlots' => TimetableSlot::where('profile_id', profile()->profile_id)->orderBy('class_day')->get()
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to add new timetable slot. Please try again.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function editTimetableSlot(Request $request, $profile_id, $class_subject_code) {
        $validatedData = $request->validate([
            'profile_id' => 'required|integer|exists:profile,profile_id',
            'class_subject_code' => 'required|string|max:12',
            'class_name' => 'required|string|max:255',
            'class_category' => 'required|string|in:lecture,labprac,tutorial,cocurricular',
            'class_section' => 'required|integer|min:1',
            'class_location' => 'required|string|max:255',
            'class_day' => 'required|integer|between:1,7',
            'class_start_time' => 'required|date_format:H:i:s',
            'class_end_time' => 'required|date_format:H:i:s|after:class_start_time',
        ]);

        // Clash check goes here somewhere...

        try {
            $status = DB::table('timetable_slot')
                ->where('profile_id', $profile_id)
                ->where('class_subject_code', $class_subject_code)
                ->update([
                    'class_subject_code' => $validatedData['class_subject_code'],
                    'class_name' => $validatedData['class_name'],
                    'class_category' => $validatedData['class_category'],
                    'class_section' => $validatedData['class_section'],
                    'class_location' => $validatedData['class_location'],
                    'class_day' => $validatedData['class_day'],
                    'class_start_time' => $validatedData['class_start_time'],
                    'class_end_time' => $validatedData['class_end_time']
                ]);

            if ($status) {
                return response()->json([
                    'success' => true,
                    'timetableSlots' => TimetableSlot::where('profile_id', $profile_id)->orderBy('class_day')->get()
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to edit timetable slot. Please try again.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
