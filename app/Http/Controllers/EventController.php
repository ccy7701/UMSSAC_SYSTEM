<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\ClubService;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    protected $eventService;
    protected $clubService;

    public function __construct(ClubService $clubService, EventService $eventService) {
        $this->clubService = $clubService;
        $this->eventService = $eventService;
    }

    public function fetchEventsFinder(Request $request) {
        // Handle POST request for filtering
        if ($request->isMethod('post')) {
            // Redirect to the GET route with query parameters for filters
            return redirect()->route('events-finder', $request->all());
        }

        // Handle GET request as normal (including pagination and filtering)
        $search = $request->input('search', '');
        $filters = $this->getFilters($request);
        $allEvents = $this->eventService->getAllEvents($filters, $search);

        return view('events-finder.view-all-events', [
             'events' => $allEvents,
             'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
             'totalEventCount' => $allEvents->total(),
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
        $eventId = $request->query('event_id');
        $data = $this->prepareEventData($eventId);

        return view('events-finder.view-event-details', [
            'event' => $data['event'],
            'club' => $data['club'],
            'isCommitteeMember' => $this->clubService->checkCommitteeMember($data['club']->club_id, profile()->profile_id),
        ]);
    }

    public function fetchEventManagePage(Request $request) {
        $eventId = $request->query('event_id');
        $data = $this->prepareEventData($eventId);

        return view('events-finder.manage-event-details', [
            'event' => $data['event'],
            'club' => $data['club'],
            'isCommitteeMember' => $this->clubService->checkCommitteeMember($data['club']->club_id, profile()->profile_id),
        ]);
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

    private function prepareEventData($eventId) {
        $event = Event::findOrFail($eventId);

        return [
            'event' => $event,
            'club' => Club::findOrFail($event->club_id),
        ];
    }
}
