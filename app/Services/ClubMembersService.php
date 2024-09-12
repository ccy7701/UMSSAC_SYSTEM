<?php

namespace App\Services;

use App\Models\ClubMembership;
use Illuminate\Support\Facades\Log;

class ClubMembersService
{
    // Get all the profiles (students, faculty members) inside the club
    public function getClubMembers($club_id) {
        return ClubMembership::where('club_id', $club_id)
            ->with(['profile.account'])
            ->get();
    }
}
