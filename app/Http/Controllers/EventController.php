<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\ClubAndEventService;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    protected $clubAndEventService;

    public function __construct(ClubAndEventService $clubAndEventService) {
        $this->clubAndEventService = $clubAndEventService;
    }

    public function fetchEventsFinder(Request $request) {
        // Handle POST request for filtering
        if ($request->isMethod('post')) {
            // Redirect to the GET route with query parameters for filters
            return redirect()->route('events-finder', $request->all());
        }

        // Handle GET request as normal (including pagination and filtering)
        $search = $request->input('search', '');
        $filters = $this->clubAndEventService->getEventFilters($request);
        $allEvents = $this->clubAndEventService->getAllEvents($filters, $search);

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
        $this->clubAndEventService->flushEventFilters();

        return redirect()->route('events-finder');
    }

    public function fetchEventDetails(Request $request) {
        return $this->clubAndEventService->prepareAndRenderEventView($request->query('event_id'), 'events-finder.view-event-details');
    }

    public function fetchEventManagePage(Request $request) {
        return $this->clubAndEventService->prepareAndRenderEventView($request->query('event_id'), 'events-finder.manage-event-details');
    }

    public function showEventInfoEdit(Request $request) {
        return $this->clubAndEventService->prepareAndRenderEventView($request->query('event_id'), 'events-finder.edit.event-info');
    }

    public function showAddEventForm(Request $request) {
        return view('events-finder.add-new-event', [
            'club' => $this->clubAndEventService->getClubDetails($request->club_id),
        ]);
    }
    
    public function showEventImagesEdit(Request $request) {
        return $this->clubAndEventService->prepareAndRenderEventView($request->query('event_id'), 'events-finder.edit.images');
    }

    public function addNewEvent(Request $request) {
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

    public function updateEventInfo(Request $request) {
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
}
