<?php

namespace App\Http\Controllers;

use App\Models\TimetableSlot;
use App\Services\TimetableBuilderService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimetableSlotController extends Controller
{
    protected $timetableBuilderService;

    public function __construct(TimetableBuilderService $timetableBuilderService) {
        $this->timetableBuilderService = $timetableBuilderService;
    }

    public function initialiseTimetableBuilder() {
        // Leave out: $this->timetableBuilderService->getAndUpdateSubjectList();

        $timetableSlots = TimetableSlot::where('profile_id', profile()->profile_id)
            ->orderBy('class_day')
            ->get();

        return response()->json([
            'success' => true,
            'timetableSlots' => $timetableSlots
        ]);
    }

    public function getTimetableSlotData($timetable_slot_id) {
        $timetableSlot = TimetableSlot::where('timetable_slot_id', $timetable_slot_id)->first();

        return response()->json($timetableSlot);
    }

    public function getSlotsByDay($profile_id, $class_day, $exclude_timetable_slot_id = null) {
        $query = TimetableSlot::where('class_day', $class_day)
            ->where('profile_id', $profile_id);

        if ($exclude_timetable_slot_id) {
            $query->where('timetable_slot_id', '!=', $exclude_timetable_slot_id);
        }

        $timetableSlots = $query->get();

        return response()->json($timetableSlots);
    }

    public function addTimetableSlot(Request $request) {
        $validatedData = $this->handleDataValidation($request);

        try {
            $status = DB::table('timetable_slot')->insert($validatedData);

            return $this->handleResponse($status, $validatedData['profile_id']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function editTimetableSlot(Request $request, $timetable_slot_id) {
        $validatedData = $this->handleDataValidation($request);

        try {
            $status = DB::table('timetable_slot')
                ->where('timetable_slot_id', $timetable_slot_id)
                ->update([
                    'class_subject_code' => $validatedData['class_subject_code'],
                    'class_name' => $validatedData['class_name'],
                    'class_category' => $validatedData['class_category'],
                    'class_section' => $validatedData['class_section'],
                    'class_lecturer' => $validatedData['class_lecturer'],
                    'class_location' => $validatedData['class_location'],
                    'class_day' => $validatedData['class_day'],
                    'class_start_time' => $validatedData['class_start_time'],
                    'class_end_time' => $validatedData['class_end_time']
                ]);

            return $this->handleResponse($status, profile()->profile_id);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function deleteTimetableSlot($timetable_slot_id) {
        try {
            Log::info('Attempting to delete timetable slot', [
                'timetable_slot_id' => $timetable_slot_id
            ]);

            $status = DB::table('timetable_slot')
                ->where('timetable_slot_id', $timetable_slot_id)
                ->delete();

            return $this->handleResponse($status, profile()->profile_id);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getSubjectDetailsList(Request $request) {
        // Call the service to get the subject details list
        $rawList = $this->timetableBuilderService->getDetailsList(urldecode($request->source_link));
        $subjectDetailsList = $rawList->json();

        return response()->json([
            'success' => true,
            'subjectDetailsList' => $subjectDetailsList
        ]);
    }

    private function handleDataValidation(Request $request) {
        switch ($request->input('class_day')) {
            case 'Monday':
            case '1':
                $request->merge(['class_day' => 1]);
                break;
            case 'Tuesday':
            case '2':
                $request->merge(['class_day' => 2]);
                break;
            case 'Wednesday':
            case '3':
                $request->merge(['class_day' => 3]);
                break;
            case 'Thursday':
            case '4':
                $request->merge(['class_day' => 4]);
                break;
            case 'Friday':
            case '5':
                $request->merge(['class_day' => 5]);
                break;
            case 'Saturday':
            case '6':
                $request->merge(['class_day' => 6]);
                break;
            case 'Sunday':
            case '7':
                $request->merge(['class_day' => 7]);
                break;
            default:
                $request->merge(['class_day' => -1]);
                break;
        }

        return $request->validate([
            'profile_id' => 'required|integer|exists:profile,profile_id',
            'class_subject_code' => 'required|string|max:12',
            'class_name' => 'required|string|max:255',
            'class_category' => 'required|string|in:lecture,labprac,tutorial,cocurricular',
            'class_section' => 'required|integer|min:1',
            'class_lecturer' => 'required|string|max:255',
            'class_location' => 'required|string|max:255',
            'class_day' => 'required|integer|between:1,7',
            'class_start_time' => 'required|date_format:H:i:s',
            'class_end_time' => 'required|date_format:H:i:s|after:class_start_time',
        ]);
    }

    private function handleResponse($status, $profile_id) {
        if ($status) {
            return response()->json([
                'success' => true,
                'timetableSlots' => TimetableSlot::where('profile_id', $profile_id)->orderBy('class_day')->get()
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to edit timetable slot. Please try again.']);
        }
    }
}
