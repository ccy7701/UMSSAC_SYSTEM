<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableSlotController extends Controller
{
    public function showTimetableBuilder() {
        $timetableSlots = DB::table('timetable_slot')
            ->where('profile_id', profile()->profile_id)
            ->get();

        return view('timetable-builder.timetable-builder', ['timetableSlots' => $timetableSlots]);
    }
}
