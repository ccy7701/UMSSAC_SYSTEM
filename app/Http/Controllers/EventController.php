<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\BookmarkService;

class EventController extends Controller
{
    protected $bookmarkService;
    protected $eventService;

    public function __construct(BookmarkService $bookmarkService, EventService $eventService,
    ) {
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
            ['club' => Club::findOrFail($request->club_id)]
        );
    }
    
    public function showEventImagesEdit(Request $request) {
        return $this->eventService->prepareAndRenderEventView(
            $request->query('event_id'),
            'events-finder.edit.images'
        );
    }

    public function addNewEvent(Request $request) {
        return $this->eventService->handleAddNewEvent($request);
    }

    public function updateEventInfo(Request $request) {
        return $this->eventService->handleUpdateEventInfo($request);
    }

    public function addEventImage(Request $request) {
        return $this->eventService->handleAddEventImage($request);
    }

    public function deleteEventImage(Request $request) {
        return $this->eventService->handleDeleteEventImage($request);
    }

    public function deleteEvent(Request $request) {
        return $this->eventService->handleDeleteEvent($request);
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
