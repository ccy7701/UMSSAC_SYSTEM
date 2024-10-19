<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Services\BookmarkService;
use App\Services\EventService;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    protected $bookmarkService;
    protected $eventService;

    public function __construct(BookmarkService $bookmarkService, EventService $eventService) {
        $this->eventService = $eventService;
        $this->bookmarkService = $bookmarkService;
    }

    public function fetchEventsFinder(Request $request) {
        return $this->eventService->prepareAndRenderEventsFinderView($request);
    }

    public function clearFilterForGeneral() {
        return $this->eventService->flushEventFilters('events-finder');
    }

    public function fetchEventDetails(Request $request) {
        return $this->eventService->prepareAndRenderEventView(
            $request->query('event_id'),
            'events-finder.view-event-details'
        );
    }

    public function fetchEventManagePage(Request $request) {
        return $this->eventService->prepareAndRenderEventView(
            $request->query('event_id'),
            'events-finder.manage-event-details'
        );
    }

    public function showEventInfoEdit(Request $request) {
        return $this->eventService->prepareAndRenderEventView(
            $request->query('event_id'),
            'events-finder.edit.event-info'
        );
    }

    public function showAddEventForm(Request $request) {
        return view(
            'events-finder.add-new-event',
            ['club' => $this->getClubDetails($request->club_id)]
        );
    }

    private function getClubDetails($clubId) {
        return Club::findOrFail($clubId);
    }
    
    public function showEventImagesEdit(Request $request) {
        return $this->eventService->prepareAndRenderEventView(
            $request->query('event_id'),
            'events-finder.edit.images'
        );
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

    public function fetchUserEventBookmarks(Request $request) {
        return $this->bookmarkService->prepareAndRenderEventBookmarksView(
            profile()->profile_id,
            'events-finder.bookmarks',
            $request->input('search', '')
        );
    }

    public function toggleEventBookmark(Request $request) {
        return $this->bookmarkService->handleToggleEventBookmark(
            $request->event_id,
            $request->club_id,
            profile()->profile_id
        );
    }
}
