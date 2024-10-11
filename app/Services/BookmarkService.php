<?php

namespace App\Services;

use App\Models\EventBookmark;
use App\Models\StudyPartner;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    // Toggle creating or deleting the event bookmark
    public function handleToggleEventBookmark($eventId, $clubId, $profileId) {
        $route = route('events-finder.fetch-event-details', ['event_id' => $eventId, 'club_id' => $clubId]);

        // Check if the event bookmark exists
        $bookmark = EventBookmark::where('event_id', $eventId)
            ->where('profile_id', $profileId)
            ->first();

        if ($bookmark) {
            // If the bookmark exists, delete it
            EventBookmark::where('event_id', $eventId)
                ->where('profile_id', $profileId)
                ->delete();

            return redirect($route)->with('bookmark-delete', 'Event bookmark deleted successfully.');
        } else {
            // If the bookmark does not exist, create it
            EventBookmark::create([
                'event_id' => $eventId,
                'profile_id' => $profileId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return redirect($route)->with('bookmark-create', 'Event bookmark created successfully.');
        }
    }

    // Toggle creating or deleting the study partner bookmark
    public function handleToggleStudyPartnerBookmark($operationPageSource, $profileId, $studyPartnerProfileId) {
        if ($operationPageSource == 'bookmarks') {
            // If the bookmark exists, delete it
            StudyPartner::where('profile_id', $profileId)
                ->where('study_partner_profile_id', $studyPartnerProfileId)
                ->where('connection_type', 1)
                ->delete();
            return redirect()->route('study-partners-suggester.bookmarks')->with('bookmark-delete', 'Study partner bookmark deleted successfully.');
        }

        if ($operationPageSource == 'results') {
            // Check if the study partner bookmark exists
            $bookmark = $this->checkIfBookmarkExists($profileId, $studyPartnerProfileId);

            if ($bookmark) {
                // If the bookmark exists, delete it
                StudyPartner::where('profile_id', $profileId)
                    ->where('study_partner_profile_id', $studyPartnerProfileId)
                    ->where('connection_type', 1)
                    ->delete();
                return redirect()->route('study-partners-suggester.suggester-results')->with('bookmark-delete', 'Study partner bookmark deleted successfully.');
            } else {
                // If the bookmark does not exist, create it
                StudyPartner::create([
                    'profile_id' => $profileId,
                    'study_partner_profile_id' => $studyPartnerProfileId,
                    'connection_type' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                return redirect()->route('study-partners-suggester.suggester-results')->with('bookmark-create', 'Study partner bookmark created successfully.');
            }
        }
    }

    // Check if a study partner bookmark exists
    private function checkIfBookmarkExists($profileId, $studyPartnerProfileId) {
        $bookmark = StudyPartner::where('profile_id', $profileId)
            ->where('study_partner_profile_id', $studyPartnerProfileId)
            ->where('connection_type', 1)
            ->first();

        return $bookmark ? 1 : 0;
    }
}
