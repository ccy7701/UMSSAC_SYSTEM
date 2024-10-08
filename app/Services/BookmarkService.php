<?php

namespace App\Services;

use App\Models\EventBookmark;
use Illuminate\Support\Facades\DB;

class BookmarkService
{
    // Prepare all the event bookmarks to be sent to the view based on request
    public function prepareAndRenderBookmarksView($profileId, $viewName) {
        $bookmarkedEvents = EventBookmark::where('profile_id', $profileId)
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
