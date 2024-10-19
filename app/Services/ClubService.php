<?php

namespace App\Services;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\ClubMembership;
use Illuminate\Support\Facades\DB;

class ClubService
{
    protected $bookmarkService;

    public function __construct(BookmarkService $bookmarkService) {
        $this->bookmarkService = $bookmarkService;
    }

    // Prepare all the data to be sent to the clubs finder view
    public function prepareAndRenderClubsFinderView(Request $request) {
        $route = currentAccount()->account_role != 3 ? 'clubs-finder' : 'manage-clubs';
        $viewName = currentAccount()->account_role != 3
            ? 'clubs-finder.general.view-all-clubs'
            : 'clubs-finder.admin-manage.view-all-clubs';

        // Handle POST request for filtering
        if ($request->isMethod('post')) {
            $filters = $request->input('category_filter', []);
            if (empty($filters)) {
                return $this->flushClubFilters($route);
            }

            // Redirect to the GET route with query parameters for filters
            return redirect()->route($route, $request->all());
        }

        $search = $request->input('search', '');
        $filters = $this->getClubFilters($request);
        $allClubs = $this->getAllClubs($filters, $search);
    
        return view($viewName, [
            'clubs' => $allClubs,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'totalClubCount' => $allClubs->count(),
            'filters' => $filters,
            'search' => $search,
        ]);
    }

    // Get the user's CLUB category and search filters
    public function getClubFilters(Request $request) {
        // Fetch filters from form submission (may be empty if no checkboxes are selected)
        $filters = $request->input('category_filter', []);
            
        // If the form is submitted with no filters, we should treat it as clearing all filters
        if ($request->isMethod('post') && empty($filters)) {
            return []; // Explicitly return an empty array if the form is submitted with no filters
        }

        // If no form submission and no filters, retrieve saved filters from the database
        if (empty($filters)) {
            $savedFilters = DB::table('user_preference')
                ->where('profile_id', profile()->profile_id)
                ->value('club_search_filters');
            $filters = $savedFilters ? json_decode($savedFilters, true) : [];
        }

        return $filters;
    }

    // Get all clubs
    public function getAllClubs(array $filters, $search = null) {
        // Always save the filters, even if empty (to clear the saved filters)
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'club_search_filters' => json_encode($filters),
                'updated_at' => now()
            ]);
        
        // Fetch clubs based on the filters (if empty, return all clubs) and search input
        return Club::when(!empty($filters), function ($query) use ($filters) {
                return $query
                    ->whereIn('club_category', $filters);
            })
            ->when($search, function ($query) use ($search) {
                return $query
                    ->where('club_name', 'like', "%{$search}%")
                    ->orWhere('club_description', 'like', "%{$search}%");
            })
            ->paginate(12);
    }

    // Flush (clear all) of the user's CLUB search filters
    public function flushClubFilters($route) {
        // Clear the filters for the authenticated user's profile
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'club_search_filters' => json_encode([]),
                'updated_at' => now()
            ]);

        return redirect()->route($route);
    }

        // Prepare all data for the specific club
    public function prepareClubData($clubId) {
        $clubEvents = $this->getEventsForClub($clubId);

        // Find intersection between all club eventIDs and bookmarked eventIDs
        $bookmarkedEventIDs = $this->bookmarkService->getBookmarkedEventIDs();
        $allClubEventIDs = $clubEvents['eventIDs'];
        $intersectionArray = array_values(array_intersect($allClubEventIDs, $bookmarkedEventIDs));
        
        return [
            'club' => $this->getClubDetails($clubId),
            'clubMembers' => $this->getClubMembers($clubId),
            'clubMembersCount' => $this->getClubMembersCount($clubId),
            'clubEvents' => $clubEvents['clubEvents'],
            'intersectionArray' => $intersectionArray,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'isCommitteeMember' => $this->checkCommitteeMember($clubId, profile()->profile_id)
        ];
    }

    // Get the profiles (students, faculty members) inside the club
    public function getClubMembers($clubId) {
        $currentProfileId = profile()->profile_id;

        return ClubMembership::where('club_id', $clubId)
            ->with(['profile.account'])
            ->orderByRaw("CASE WHEN profile_id = ? THEN 0 ELSE 1 END", [$currentProfileId])
            ->orderBy('membership_type', 'desc')
            ->paginate(8);
    }

    // Get the count of members of the specific club
    public function getClubMembersCount($clubId) {
        return ClubMembership::where('club_id', $clubId)->count();
    }

    // Get all the events of the specific club
    public function getEventsForClub($club_id) {
        $clubEvents = Event::where('club_id', $club_id)->paginate(12);
        $eventIDs = $clubEvents->pluck('event_id')->toArray();

        return compact('clubEvents', 'eventIDs');
    }

    // Get the details of the specific club
    public function getClubDetails($clubId) {
        return Club::findOrFail($clubId);
    }

    // Check and determine if the current user is a committee member of the club
    public function checkCommitteeMember($clubId, $profileId) {
        return ClubMembership::where('club_id', $clubId)
            ->where('profile_id', $profileId)
            ->where('membership_type', 2)
            ->exists();
    }
}
