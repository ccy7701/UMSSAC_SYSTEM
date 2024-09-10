<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\Event;
use App\Models\UserPreference;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClubController extends Controller
{
    public function fetchAllClubs(Request $request) {
        // Get filters from the form submission
        $filters = $request->input('faculty_filter', []); // Default to an empty array if no filters are selected
    
        // If no filters were submitted, get saved filters from the database
        if (empty($filters)) {
            $savedFilters = DB::table('user_preference')
                ->where('profile_id', profile()->profile_id)
                ->value('club_search_filters'); // Get the saved filters from the JSON column

            // Decode the JSON into an array (it could be null if no filters are saved)
            $filters = $savedFilters ? json_decode($savedFilters, true) : [];
        } else {
            // If filters were submitted, save them in the database
            DB::table('user_preference')
                ->where('profile_id', profile()->profile_id)
                ->update([
                    'club_search_filters' => json_encode($filters),
                    'updated_at' => now()
                ]);
        }
    
        // Fetch clubs based on stored filters
        $allClubs = Club::when(!empty($filters), function($query) use ($filters) {
            return $query->whereIn('club_faculty', $filters);
        })->get();
    
        // Return the view with filtered clubs
        return view('clubs-finder.view-all-clubs', [
            'clubs' => $allClubs,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'totalClubCount' => $allClubs->count(),
            'filters' => $filters // Pass filters back to the view for checkbox selections
        ]);
    }

    public function clearFilter() {
        // Clear the filters for the authenticated user's profile
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'club_search_filters' => json_encode([]),
                'updated_at' => now()
            ]);
    
        return redirect()->route('clubs-finder');
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
}
