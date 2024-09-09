<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;

class ClubController extends Controller
{
    public function fetchAllClubs() {
        // Fetch all clubs from the database
        $allClubs = Club::all();

        return view('clubs-finder.view-all-clubs', [
            'clubs' => $allClubs,
            'totalClubCount' => $allClubs->count(),
        ]);
    }

    public function fetchClubDetails(Request $request) {
        // Get 'club_id' from the query string
        $club_id = $request->query('club_id');

        // Find the club using the club_id
        $club = Club::findOrFail($club_id);

        // Return a view with the club details
        return view('clubs-finder.view-club-details', compact('club'));
    }
}
