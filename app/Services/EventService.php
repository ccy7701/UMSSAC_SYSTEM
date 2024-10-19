<?php

namespace App\Services;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventBookmark;
use App\Models\ClubMembership;
use Illuminate\Support\Facades\DB;

class EventService
{
    protected $bookmarkService;

    public function __construct(BookmarkService $bookmarkService) {
        $this->bookmarkService = $bookmarkService;
    }

    // Prepare all the data to be sent to the events finder view
    public function prepareAndRenderEventsFinderView(Request $request) {
        // Handle POST request for filtering
        if ($request->isMethod('post')) {
            // Check if the filters are empty in the POST request
            $filters = [
                'category_filter' => $request->input('category_filter', []),
                'event_status' => $request->input('event_status', []),
            ];
            if (empty($filters['category_filter']) && empty($filters['event_status'])) {
                // Proceed as if flushing the search filters
                return $this->flushEventFilters('events-finder');
            }
            // Redirect to the GET route with query parameters for filters
            return redirect()->route('events-finder', $request->all());
        }

        // Handle GET request as normal (including pagination and filtering)
        $search = $request->input('search', '');
        $filters = $this->getEventFilters($request);

        // Get paginated events and their event_ids
        $data = $this->getAllEvents($filters, $search);
        $allEvents = $data['allEvents'];

        // Find intersection between all eventIDs and bookmarked eventIDs
        $bookmarkedEventIDs = $this->bookmarkService->getBookmarkedEventIDs();
        $allEventIDs = $data['eventIDs'];
        $intersectionArray = array_values(array_intersect($allEventIDs, $bookmarkedEventIDs));

        return view('events-finder.view-all-events', [
             'events' => $allEvents,
             'intersectionArray' => $intersectionArray,
             'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
             'totalEventCount' => $allEvents->total(),
             'filters' => $filters,
             'search' => $search
        ]);
    }

    // Get the user's EVENT category and search filters
    public function getEventFilters(Request $request) {
        // Fetch filters from form submission (may be empty if no checkboxes are selected)
        $filters = [
            'category_filter' => $request->input('category_filter', []),
            'event_status' => $request->input('event_status', []),
        ];

        // If no form submission and no filters, retrieve saved filters from the DB
        if (empty($filters['category_filter']) && empty($filters['event_status'])) {
            $savedFilters = DB::table('user_preference')
                ->where('profile_id', profile()->profile_id)
                ->value('event_search_filters');
            $filters = $savedFilters ? json_decode($savedFilters, true) : [];
        }

        return $filters;
    }

    // Get all club events for all clubs
    public function getAllEvents(array $filters, $search = null) {
        // Always save the filters, even if empty (to clear the saved filters)
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'event_search_filters' => json_encode($filters),
                'updated_at' => now()
            ]);

        // Fetch events based on the filters (if empty, return all events) and search input
        $allEvents = Event::join('club', 'event.club_id', '=', 'club.club_id')
            ->when(!empty($filters['category_filter']), function ($query) use ($filters) {
                return $query->whereIn('club.club_category', $filters['category_filter']);
            })
            ->when(!empty($filters['event_status']), function ($query) use ($filters) {
                return $query->whereIn('event.event_status', $filters['event_status']);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('event.event_name', 'like', "%{$search}%")
                      ->orWhere('event.event_description', 'like', "%{$search}%");
                });
            })
            ->select('event.*')
            ->paginate(12);

        // Get only the event_ids from the paginated events
        $eventIDs = $allEvents->pluck('event_id')->toArray();

        return compact('allEvents', 'eventIDs');
    }

    // Flush (clear all) of the user's EVENT search filters
    public function flushEventFilters($route) {
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'event_search_filters' => json_encode([]),
                'updated_at' => now()
            ]);

        return redirect()->route($route);
    }

    // Prepare all the data to be sent to the view based on request
    public function prepareAndRenderEventView($eventId, $viewName) {
        $event = Event::findOrFail($eventId);
        $club = Club::findOrFail($event->club_id);
        $bookmark = EventBookmark::where('event_id', $eventId)
            ->where('profile_id', profile()->profile_id)
            ->first();
        $isCommitteeMember = $this->checkCommitteeMember($club->club_id, profile()->profile_id);
        
        return view($viewName, [
            'event' => $event,
            'club' => $club,
            'isBookmarked' => $bookmark ? 1 : 0,
            'isCommitteeMember' => $isCommitteeMember
        ]);
    }

    // Check and determine if the current user is a committee member of the club
    private function checkCommitteeMember($clubId, $profileId) {
        return ClubMembership::where('club_id', $clubId)
            ->where('profile_id', $profileId)
            ->where('membership_type', 2)
            ->exists();
    }
}
