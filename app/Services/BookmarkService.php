<?php

namespace App\Services;

use App\Models\EventBookmark;
use App\Models\StudyPartner;
use Illuminate\Support\Facades\DB;

class BookmarkService
{
    // Prepare all the event bookmarks to be sent to the view based on request
    public function prepareAndRenderBookmarksView($bookmarkType, $profileId, $viewName, $search = null, ) {
        $bookmarks = null;
        $totalBookmarks = 0;

        if ($bookmarkType == 'events') {
            $bookmarks = EventBookmark::where('profile_id', $profileId)
                ->whereHas('event', function($query) use ($search) {
                    if ($search) {
                        $query->where('event_name', 'like', '%' . $search . '%')
                            ->orWhere('event_location', 'like', '%' . $search . '%');
                    }
                })
                ->with(['event.club'])
                ->get();
            $totalBookmarks = $bookmarks->count();
        } elseif ($bookmarkType == 'study_partners') {
            $bookmarks = StudyPartner::where('profile_id', $profileId)
                ->where('connection_type', 1)
                ->whereHas('studyPartnerProfile.account', function($query) use ($search) {
                    if ($search) {
                        $query->where('account_full_name', 'like', '%' . $search . '%');
                    }
                })
                ->orWhereHas('profile', function($query) use ($search) {
                    if ($search) {
                        $query->where('profile_faculty', 'like', '%' . $search . '%');
                    }
                })
                ->with([
                    'studyPartnerProfile.account' => function($query) {
                        $query->select('account_id', 'account_full_name', 'account_email_address', 'account_matric_number');
                    },
                    'studyPartnerProfile' => function($query) {
                        $query->select('profile_id', 'account_id', 'profile_nickname', 'profile_personal_desc', 'profile_faculty', 'profile_picture_filepath');
                    }
                ])
                ->get();
            $totalBookmarks = $bookmarks->count();
        }

        return view($viewName, [
            'bookmarks' => $bookmarks,
            'totalBookmarks' => $totalBookmarks,
            'searchViewPreference' => getUserSearchViewPreference($profileId)
        ]);
    }
}
