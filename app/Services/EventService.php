<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventBookmark;
use App\Models\ClubMembership;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    // Handle adding a new event
    public function handleAddNewEvent(Request $request) {
        $validatedData = $request->validate([
            'new_event_name' => 'required|string|max:128',
            'new_event_location' => 'required|string|max:255',
            'new_event_datetime' => 'required|date_format:Y-m-d\TH:i',
            'new_event_description' => 'required|string|max:1024',
            'new_event_entrance_fee' => 'nullable|numeric|min:0',
            'new_event_sdp_provided' => 'required|boolean',
            'new_event_registration_link' => 'required|string|max:255',
            'new_event_status' => 'required|boolean',
            'new_event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the image upload, if present
        $imagePath = $request->hasFile('new_event_image')
            ? $request->file('new_event_image')->store('event-images', 'public')
            : '';

        $event = Event::create([
            'club_id' => $request->club_id,
            'event_name' => $validatedData['new_event_name'],
            'event_location' => $validatedData['new_event_location'],
            'event_datetime' => $validatedData['new_event_datetime'],
            'event_description' => $validatedData['new_event_description'],
            'event_entrance_fee' => $validatedData['new_event_entrance_fee'],
            'event_sdp_provided' => $validatedData['new_event_sdp_provided'],
            'event_image_paths' => json_encode($imagePath ? [$imagePath]: []),
            'event_registration_link' => $validatedData['new_event_registration_link'],
            'event_status' => $validatedData['new_event_status'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $event
            ? redirect()->route('events-finder.fetch-event-details', ['event_id' => $event->event_id])->with('success', 'New event added successfully!')
            : back()->withErrors(['errors' => 'Failed to add new event. Please try again.']);
    }

    // Handle updating existing event's info
    public function handleUpdateEventInfo(Request $request) {
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:128',
            'event_location' => 'required|string|max:255',
            'event_datetime' => 'required|date_format:Y-m-d\TH:i',
            'event_description' => 'required|string|max:1024',
            'event_entrance_fee' => 'nullable|numeric|min:0',
            'event_sdp_provided' => 'required|boolean',
            'event_registration_link' => 'required|string|max:255',
            'event_status' => 'required|boolean',
        ]);

        // Convert the event datetime to Carbon
        $validatedData['event_datetime'] = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['event_datetime']);
        $validatedData['updated_at'] = Carbon::now();

        $event = Event::where('event_id', $request->event_id)->firstOrFail();
        $status = $event->update($validatedData);
        
        $route = route('events-finder.manage-details', [
            'event_id' => $event->event_id,
            'club_id' => $event->club_id
        ]);
        
        return $status
            ? redirect($route)->with('success', 'Event info updated successfully!')
            : back()->withErrors(['error' => 'Failed to update event info. Please try again.']);
    }

    public function handleAddEventImage(Request $request) {
        $request->validate([
            'new_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $event = Event::findOrFail($request->event_id);
        $currentImages = json_decode($event->getRawOriginal('event_image_paths'), true) ?? [];
        $newImagePath = $request->file('new_image')->store('event-images', 'public');
        $currentImages[] = $newImagePath;

        $event->event_image_paths = json_encode($currentImages);
        $status = $event->save();

        $route = route('event-manage.edit-images', ['event_id' => $event->event_id, 'club_id' => $request->club_id]);

        return $status
            ? redirect($route)->with('success', 'Event image added successfully!')
            : back()->withErrors(['error' => 'Failed to add event image. Please try again.']);
    }

    public function handleDeleteEventImage(Request $request) {
        $event = Event::findOrFail($request->event_id);
        $currentImages = json_decode($event->getRawOriginal('event_image_paths'), true) ?? [];
        $imageToDeleteIndex = $request->input('key');
        $imagePath = $currentImages[$imageToDeleteIndex] ?? null;

        if ($imagePath) {
            Storage::delete('public/'.$imagePath);
        }

        unset($currentImages[$imageToDeleteIndex]);
        $currentImages = array_values($currentImages);

        $event->event_image_paths = json_encode($currentImages);
        $status = $event->save();

        $route = route('event-manage.edit-images', ['event_id' => $event->event_id, 'club_id' => $request->club_id]);

        return $status
            ? redirect($route)->with('success', 'Event image deleted successfully.')
            : back()->withErrors(['error' => 'Failed to delete event image. Please try again.']);
    }

    public function handleDeleteEvent(Request $request) {
        $eventId = $request->input('event_id');
        $clubId = $request->input('club_id');

        $event = Event::where('event_id', $eventId)->firstOrFail();
        $currentImagePaths = json_decode($event->getRawOriginal('event_image_paths'), true) ?? [];
        
        foreach ($currentImagePaths as $imagePath) {
            Storage::delete('public/'.$imagePath);
        }

        $status = $event->delete();

        return $status
            ? redirect()->route('committee-manage.manage-details', ['club_id' => $clubId])->with('success', 'Event deleted successfully.')
            : back()->withErrors(['error' => 'Failed to delete event. Please try again.']);
    }

    // Check and determine if the current user is a committee member of the club
    private function checkCommitteeMember($clubId, $profileId) {
        return ClubMembership::where('club_id', $clubId)
            ->where('profile_id', $profileId)
            ->where('membership_type', 2)
            ->exists();
    }
}
