<?php

namespace App\Services;

use App\Models\ClubMembership;
use Illuminate\Support\Facades\Log;

class ClubMembersService
{
    // Get all the profiles (students, faculty members) inside the club
    public function getClubMembers($club_id) {
        $currentProfileId = profile()->profile_id;

        return ClubMembership::where('club_id', $club_id)
            ->with(['profile.account'])
            ->orderByRaw("CASE WHEN profile_id = ? THEN 0 ELSE 1 END", [$currentProfileId])
            ->orderBy('membership_type', 'desc')
            ->get();
    }
}
