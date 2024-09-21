<?php

namespace App\Services;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\ClubMembership;
use Illuminate\Support\Facades\DB;

class ClubAndEventService
{
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
            ->paginate(9);
    }

    // Prepare all data for the specific club
    public function prepareClubData($clubId) {
        return [
            'club' => $this->getClubDetails($clubId),
            'clubMembers' => $this->getClubMembers($clubId),
            'clubEvents' => $this->getEventsForClub($clubId),
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'isCommitteeMember' => $this->checkCommitteeMember($clubId, profile()->profile_id)
        ];
    }

    // Get the details of the specific club
    public function getClubDetails($clubId) {
        return Club::findOrFail($clubId);
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

    // Get all the events of the specific club
    public function getEventsForClub($club_id) {
        return Event::where('club_id', $club_id)->paginate(9);
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
        return Event::join('club', 'event.club_id', '=', 'club.club_id')
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
            ->paginate(9);
    }

    // Prepare all the data to be sent to the view based on request
    public function prepareAndRenderEventView($eventId, $viewName) {
        $event = Event::findOrFail($eventId);
        $club = Club::findOrFail($event->club_id);

        $isCommitteeMember = $this->checkCommitteeMember($club->club_id, profile()->profile_id);
        
        return view($viewName, [
            'event' => $event,
            'club' => $club,
            'isCommitteeMember' => $isCommitteeMember
        ]);
    }

    // Check and determine if the current user is a committee member of the club
    public function checkCommitteeMember($club_id, $profile_id) {
        return ClubMembership::where('club_id', $club_id)
            ->where('profile_id', $profile_id)
            ->where('membership_type', 2)
            ->exists();
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

    // Get the user's EVENT category and search filters
    public function getEventFilters(Request $request) {
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

    // Flush (clear all) of the user's CLUB search filters
    public function flushClubFilters() {
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'club_search_filters' => json_encode([]),
                'updated_at' => now()
            ]);
    }

    // Flush (clear all) of the user's EVENT search filters
    public function flushEventFilters() {
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'event_search_filters' => json_encode([]),
                'updated_at' => now()
            ]);
    }
}
