<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function fetchAllEvents() {
        // Fetch all events from the database
        $allEvents = Event::all();

        return view('events-finder.view-all-events', [
            'events' => $allEvents,
            'totalEventCount' => $allEvents->count(),
        ]);
    }

    public function fetchEventDetails(Request $request) {
        // Get 'event_id' from the query string
        $event_id = $request->query('event_id');

        // Find the event using the event_id
        $event = Event::findOrFail($event_id);

        // Return a view with the event details
        return view('events-finder.view-event-details', compact('event'));
    }
}
