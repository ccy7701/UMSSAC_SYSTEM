<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\Event;
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

    public function fetchClubDetailsForGeneral(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);
        
        // Return a view with the club details, events, members and view preference
        return view('clubs-finder.general.view-club-details', $data);
    }

    public function fetchClubsManager(Request $request) {
        $search = $request->input('search');
        $filters = $this->getFilters($request);
        $allClubs = $this->getAllClubs($filters, $search);

        return view('clubs-finder.admin-manage.view-all-clubs', [
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

    public function fetchClubDetailsForManager(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);
        
        return view('clubs-finder.admin-manage.view-club-details', $data);
    }

    public function fetchCommitteeManagePage(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);

        return view('clubs-finder.committee-manage.manage-club-details', $data);
    }

    public function fetchAdminManagePage(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);

        return view('clubs-finder.admin-manage.manage-club-details', $data);
    }

    public function showClubInfoEditForm(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);

        return view('clubs-finder.admin-manage.edit-club-info', [
            'club' => $data['club'],
        ]);
    }

    public function updateClubInfo(Request $request) {

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

    private function prepareClubData($clubId) {
        $clubMembersService = new ClubMembersService();

        return [
            'club' => $this->getClubDetails($clubId),
            'clubMembers' => $clubMembersService->getClubMembers($clubId),
            'clubEvents' => $this->getClubEvents($clubId),
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'isCommitteeMember' => $clubMembersService->checkCommitteeMember($clubId, profile()->profile_id)
        ];
    }

    private function getClubDetails($club_id) {
        return Club::findOrFail($club_id);
    }

    private function getClubEvents($club_id) {
        return Event::where('club_id', $club_id)->get();
    }
}
