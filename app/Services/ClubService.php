<?php

namespace App\Services;

use App\Models\Club;
use App\Models\ClubMembership;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ClubService
{
    // Get all clubs from the DB
    public function getAllClubs(array $filters, $search = null) {
        // Always save the filters, even if empty (to clear the saved filters)
        $this->flushFilters();
    
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

    // Get the club details
    public function getClubDetails($club_id) {
        return Club::findOrFail($club_id);
    }

    // Get all the profiles (students, faculty members) inside the club
    public function getClubMembers($club_id) {
        $currentProfileId = profile()->profile_id;

        return ClubMembership::where('club_id', $club_id)
            ->with(['profile.account'])
            ->orderByRaw("CASE WHEN profile_id = ? THEN 0 ELSE 1 END", [$currentProfileId])
            ->orderBy('membership_type', 'desc')
            ->paginate(8);
    }

    // Determine if the current user is a committee member
    public function checkCommitteeMember($club_id, $profile_id) {
        return ClubMembership::where('club_id', $club_id)
            ->where('profile_id', $profile_id)
            ->where('membership_type', 2)
            ->exists();
    }

    // Get the user's search filters
    public function getFilters(Request $request) {
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

    // Flush (clear all) of the user's search filters
    public function flushFilters() {
        DB::table('user_preference')
        ->where('profile_id', profile()->profile_id)
        ->update([
            'club_search_filters' => json_encode([]),
            'updated_at' => now()
        ]);
    }
}
