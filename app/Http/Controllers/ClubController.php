<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\Event;

class ClubController extends Controller
{
    public function fetchAllClubs() {
        // Fetch all clubs from the database
        $allClubs = Club::all();
        $searchViewPreference = getUserSearchViewPreference(profile()->profile_id);

        return view('clubs-finder.view-all-clubs', [
            'clubs' => $allClubs,
            'searchViewPreference' => $searchViewPreference,
            'totalClubCount' => $allClubs->count(),
        ]);
    }

    public function fetchClubDetails(Request $request) {
        $club_id = $request->query('club_id');
        $club = Club::findOrFail($club_id);
        $clubEvents = Event::where('club_id', $club_id)->get();
        $searchViewPreference = getUserSearchViewPreference(profile()->profile_id);

        // Return a view with the club details
        return view(
            'clubs-finder.view-club-details',
            compact('club', 'clubEvents', 'searchViewPreference'),
        );
    }

    // public function clubScopeFilter(Request $request) {
    //     $selectedFaculties =
    // }
}
