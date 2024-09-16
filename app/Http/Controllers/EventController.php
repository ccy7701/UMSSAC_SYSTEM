<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService) {
        $this->eventService = $eventService;
    }

    public function fetchEventsFinder(Request $request) {
        $search = $request->input('search');
        $filters = $this->getFilters($request);
        $allEvents = $this->eventService->getAllEvents($filters, $search);

        return view('events-finder.view-all-events', [
            'events' => $allEvents,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'totalEventCount' => $allEvents->count(),
            'filters' => $filters,
            'search' => $search,
        ]);
    }

    public function clearFilterForGeneral() {
        // Clear the filters for the authenticated user's profile
        $this->flushFilters();

        return redirect()->route('events-finder');
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

    private function getFilters(Request $request) {
        // Fetch filters from form submission (may be empty if no checkboxes are selected)
        $filters = [
            'category_filter' => $request->input('category_filter', []),
            'event_status' => $request->input('event_status', []),
        ];
    
        // If the form is submitted with no filters, treat it as clearing all filters
        if ($request->isMethod('post') && empty($filters['category_filter']) && empty($filters['event_status'])) {
            return [];
        }

        // If no form submission and no filters, retrieve saved filters from the DB
        if (empty($filters['category_filter']) && empty($filters['event_status'])) {
            $savedFilters = DB::table('user_preference')
                ->where('profile_id', profile()->profile_id)
                ->value('event_search_filters');
            $filters = $savedFilters ? json_decode($savedFilters, true) : [];
        }

        return $filters;
    }

    private function flushFilters() {
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'event_search_filters' => json_encode([]),
                'updated_at' => now()
            ]);
    }
}
