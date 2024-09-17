<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\ClubService;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'event_search_filters' => json_encode([]),
                'updated_at' => now()
            ]);

        return redirect()->route('events-finder');
    }

    public function fetchEventDetails(Request $request) {
        return $this->eventService->prepareAndRenderEventView($request->query('event_id'), 'events-finder.view-event-details');
    }

    public function fetchEventManagePage(Request $request) {
        return $this->eventService->prepareAndRenderEventView($request->query('event_id'), 'events-finder.manage-event-details');
    }

    public function showEventInfoEdit(Request $request) {
        return $this->eventService->prepareAndRenderEventView($request->query('event_id'), 'events-finder.edit.event-info');
    }

    public function showAddEventForm(Request $request) {
        return view('events-finder.add-new-event', [
            'club' => $this->clubService->getClubDetails($request->club_id),
        ]);
    }

    public function updateEventInfo(Request $request) {
        $validatedData = $request->validate([
            'event_name' => 'required|string|max:128',
            'event_location' => 'required|string|max:255',
            'event_datetime' => 'required|date_format:Y-m-d\TH:i',
            'event_description' => 'required|string|max:1024',
            'event_entrance_fee' => 'nullable|numeric|min:0',
            'event_sdp_provided' => 'required|boolean',
            'event_registration_link' => 'nullable|url|max:255',
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

    public function showEventImagesEdit(Request $request) {
        return $this->eventService->prepareAndRenderEventView($request->query('event_id'), 'events-finder.edit.images');
    }

    public function addEventImage(Request $request) {
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

    public function deleteEventImage(Request $request) {
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

    public function deleteEvent(Request $request) {
        $eventId = $request->input('event_id');
        $clubId = $request->input('club_id');

        $event = Event::where('event_id', $eventId)->firstOrFail();
        $status = $event->delete();

        return $status
            ? redirect()->route('committee-manage.manage-details', ['club_id' => $clubId])->with('success', 'Event deleted successfully.')
            : back()->withErrors(['error' => 'Failed to delete event. Please try again.']);
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
}
