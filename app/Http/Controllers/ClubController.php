<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\Event;
use App\Models\UserPreference;
use App\Services\ClubMembersService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClubController extends Controller
{
    public function fetchClubsFinder(Request $request) {
        $search = $request->input('search');
        $filters = $this->getFilters($request);
        $allClubs = $this->getAllClubs($filters, $search);
    
        return view('clubs-finder.general.view-all-clubs', [
            'clubs' => $allClubs,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'totalClubCount' => $allClubs->count(),
            'filters' => $filters,
            'search' => $search,
        ]);
    }

    public function clearFilterForGeneral() {
        // Clear the filters for the authenticated student's profile
        $this->flushFilters();

        return redirect()->route('clubs-finder');
    }

    // REFACTOR REQUIRED!
    public function fetchClubDetailsForGeneral(Request $request) {
        $clubId = $request->query('club_id');
        $clubMembersService = new ClubMembersService();
        
        // Return a view with the club details, events, members and view preference
        return view('clubs-finder.general.view-club-details', [
            'club' => $this->getClubDetails($clubId),
            'clubEvents' => $this->getClubEvents($clubId),
            'clubMembers' => $clubMembersService->getClubMembers($clubId),
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
        ]);
    }

    public function fetchClubsManager(Request $request) {
        $search = $request->input('search');
        $filters = $this->getFilters($request);
        $allClubs = $this->getAllClubs($filters, $search);

        return view('clubs-finder.manage.view-all-clubs', [
            'clubs' => $allClubs,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'totalClubCount' => $allClubs->count(),
            'filters' => $filters,
            'search' => $search,
        ]);
    }

    public function clearFilterForManager() {
        // Clear the filters for the manager's (i.e. admin's) profile
        $this->flushFilters();
    
        return redirect()->route('manage-clubs');
    }

    // REFACTOR REQUIRED!
    public function fetchClubDetailsForManager(Request $request) {
        $clubId = $request->query('club_id');
        $clubMembersService = new ClubMembersService();
        
        // Return a view with the club details, events, members and view preference
        return view('clubs-finder.manage.view-club-details', [
            'club' => $this->getClubDetails($clubId),
            'clubEvents' => $this->getClubEvents($clubId),
            'clubMembers' => $clubMembersService->getClubMembers($clubId),
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
        ]);
    }

    public function fetchEditForm(Request $request) {
        $clubId = $request->query('club_id');
        $clubMembersService = new ClubMembersService();

        return view('clubs-finder.manage.edit-club-details', [
            'club' => $this->getClubDetails($clubId),
            'clubMembers' => $clubMembersService->getClubMembers($clubId),
        ]);
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

    private function getAllClubs(array $filters, $search = null) {
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
                    ->whereIn('club_faculty', $filters);
            })
            ->when($search, function ($query) use ($search) {
                return $query
                    ->where('club_name', 'like', "%{$search}%")
                    ->orWhere('club_description', 'like', "%{$search}%");
            })
            ->get();
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
        return Club::findOrFail($club_id);
    }

    private function getClubEvents($club_id) {
        return Event::where('club_id', $club_id)->get();
    }
}
