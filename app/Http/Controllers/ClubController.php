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
    public function fetchClubsFinder(Request $request) {
        $filters = $this->getFilters($request);
        $allClubs = $this->getAllClubs($filters);
    
        return view('clubs-finder.general.view-all-clubs', [
            'clubs' => $allClubs,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'totalClubCount' => $allClubs->count(),
            'filters' => $filters
        ]);
    }

    public function clearFilterForGeneral() {
        // Clear the filters for the authenticated student's profile
        $this->flushFilters();

        return redirect()->route('clubs-finder');
    }

    public function fetchClubDetailsForGeneral(Request $request) {
        $club_id = $request->query('club_id');
        $data = $this->getClubDetails($club_id);

        // Return a view with the club details
        return view('clubs-finder.general.view-club-details', $data);
    }

    public function fetchClubsManager(Request $request) {
        $filters = $this->getFilters($request);
        $allClubs = $this->getAllClubs($filters);

        return view('clubs-finder.manage.view-all-clubs', [
            'clubs' => $allClubs,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'totalClubCount' => $allClubs->count(),
            'filters' => $filters
        ]);
    }

    public function clearFilterForManager() {
        // Clear the filters for the manager's (i.e. admin's) profile
        $this->flushFilters();
    
        return redirect()->route('manage-clubs');
    }

    public function fetchClubDetailsForManager(Request $request) {
        $club_id = $request->query('club_id');
        $data = $this->getClubDetails($club_id);

        return view('clubs-finder.manage.view-club-details', $data);
    }

    public function fetchEditForm(Request $request) {
        $club_id = $request->query('club_id');
        $data = $this->getClubDetails($club_id);

        return view('clubs-finder.manage.edit-club-details', $data);
    }

    private function getFilters(Request $request) {
        // Fetch filters from form submission (may be empty if no checkboxes are selected)
        $filters = $request->input('faculty_filter', []);
    
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

    private function getAllClubs(array $filters) {
        // Always save the filters, even if empty (to clear the saved filters)
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'club_search_filters' => json_encode($filters),
                'updated_at' => now()
            ]);
    
        // Fetch clubs based on the filters (if empty, return all clubs)
        return Club::when(!empty($filters), function($query) use ($filters) {
            return $query->whereIn('club_faculty', $filters);
        })->get();
    }

    private function flushFilters() {
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'club_search_filters' => json_encode([]),
                'updated_at' => now()
            ]);
    }

    private function getClubDetails($club_id) {
        $club = Club::findOrFail($club_id);
        $clubEvents = Event::where('club_id', $club_id)->get();
        $searchViewPreference = getUserSearchViewPreference(profile()->profile_id);

        return compact('club', 'clubEvents', 'searchViewPreference');
    }
}
