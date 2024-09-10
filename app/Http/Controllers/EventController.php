<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Club;

class EventController extends Controller
{
    public function fetchAllEvents() {
        // Fetch all events from the database
        $allEvents = Event::all();
        $searchViewPreference = getUserSearchViewPreference(profile()->profile_id);

        return view('events-finder.view-all-events', [
            'events' => $allEvents,
            'searchViewPreference' => $searchViewPreference,
            'totalEventCount' => $allEvents->count(),
        ]);
    }

    public function fetchEventDetails(Request $request) {
        $event_id = $request->query('event_id');
        $event = Event::findOrFail($event_id);
        $club = Club::findOrFail($event->club_id);

        return view(
            'events-finder.view-event-details',
            compact('event', 'club')
        );
    }
}
