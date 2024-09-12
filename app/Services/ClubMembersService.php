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

    // Determine if the current user is a committee member
    public function checkCommitteeMember($clubId, $profileId) {
        return ClubMembership::where('club_id', $clubId)
            ->where('profile_id', $profileId)
            ->where('membership_type', 2)
            ->exists();
    }
}
