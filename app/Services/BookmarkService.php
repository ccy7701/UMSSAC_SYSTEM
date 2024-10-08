<?php

namespace App\Services;

use App\Models\EventBookmark;
use Illuminate\Support\Facades\DB;

class BookmarkService
{
    // Prepare all the event bookmarks to be sent to the view based on request
    public function prepareAndRenderBookmarksView($search, $profileId, $viewName) {
        // Fetch bookmarked events based on the search filter
        $bookmarkedEvents = EventBookmark::where('profile_id', $profileId)
            ->whereHas('event', function($query) use ($search) {
                if ($search) {
                    $query->where('event_name', 'like', '%' . $search . '%')
                        ->orWhere('event_location', 'like', '%' . $search . '%');
                }
            })
            ->with(['event.club'])
            ->get();

        $totalBookmarks = $bookmarkedEvents->count();

        return view($viewName, [
            'bookmarkedEvents' => $bookmarkedEvents,
            'totalBookmarks' => $totalBookmarks,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
        ]);
    }
}
