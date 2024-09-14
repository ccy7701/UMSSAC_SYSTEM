<?php

namespace App\Services;

use App\Models\Club;
use App\Models\ClubMembership;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ClubService
{
    // Get all clubs from the DB
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
            ->get();
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
            ->get();
    }

    // Determine if the current user is a committee member
    public function checkCommitteeMember($clubId, $profileId) {
        return ClubMembership::where('club_id', $clubId)
            ->where('profile_id', $profileId)
            ->where('membership_type', 2)
            ->exists();
    }
}
