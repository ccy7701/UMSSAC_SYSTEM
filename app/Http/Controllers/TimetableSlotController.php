<?php

namespace App\Http\Controllers;

use App\Models\TimetableSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableSlotController extends Controller
{
    public function initialiseTimetable() {
        $timetableSlots = TimetableSlot::where('profile_id', profile()->profile_id)->get();

        return response()->json([
            'success' => true,
            'timetableSlots' => $timetableSlots
        ]);
    }
}
