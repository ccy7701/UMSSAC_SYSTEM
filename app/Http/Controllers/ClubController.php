<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\Event;
use App\Services\ClubService;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ClubController extends Controller
{
    protected $clubService;
    protected $eventService;

    public function __construct(ClubService $clubService, EventService $eventService) {
        $this->clubService = $clubService;
        $this->eventService = $eventService;
    }

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

    public function showClubInfoEditForAdmin(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);

        return view('clubs-finder.admin-manage.edit.club-info', [
            'club' => $data['club'],
        ]);
    }

    public function showClubInfoEditForCommittee(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);

        return view('clubs-finder.committee-manage.edit.club-info', [
            'club' => $data['club'],
        ]);
    }

    public function showClubImagesEditForAdmin(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);

        return view('clubs-finder.admin-manage.edit.images', [
            'club' => $data['club'],
        ]);
    }

    public function showClubImagesEditForCommittee(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);

        return view('clubs-finder.committee-manage.edit.images', [
            'club' => $data['club'],
        ]);
    }

    public function showClubMembersForAdmin(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);

        return view('clubs-finder.admin-manage.edit.members-access', [
            'club' => $data['club'],
            'clubMembers' => $data['clubMembers'],
            'isCommitteeMember' => $data['isCommitteeMember'],
        ]);
    }

    public function showClubMembersForCommittee(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubData($clubId);

        return view('clubs-finder.committee-manage.edit.members-access', [
            'club' => $data['club'],
            'clubMembers' => $data['clubMembers'],
            'isCommitteeMember' => $data['isCommitteeMember'],
        ]);
    }

    public function updateClubInfo(Request $request) {
        $validatedData = $request->validate([
            'club_name' => 'required|string|max:128',
            'club_category' => 'required|string',
            'club_description' => 'required|string|max:1024',
        ]);

        // Fetch the club to update
        $club = Club::where('club_id', $request->club_id)->firstOrFail();

        // Update the club with the validated data
        $status = $club->update($validatedData);

        // Get the view based on logged in account's role
        $route = '';
        if (currentAccount()->account_role != 3) {
            $route = route('committee-manage.manage-details', ['club_id' => $club->club_id]);
        } else {
            $route = route('admin-manage.manage-details', ['club_id' => $club->club_id]);
        }
        
        return $status
            ? redirect($route)->with('success', 'Club info updated successfully!')
            : back()->withErrors(['error' => 'Failed to update club info. Please try again.']);
    }

    public function updateClubImages(Request $request) {
        // Validate if a new image is uploaded
        $request->validate([
            'new_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Retrieve the club by ID
        $club = Club::findOrFail($request->club_id);
    
        // Get the existing image paths from the database (skip accessor)
        $currentImages = json_decode($club->getRawOriginal('club_image_paths'), true) ?? [];
    
        // **Handle Deletion**
        if ($request->has('delete_image')) {
            // Get the index of the image to delete
            $imageIndex = $request->input('delete_image');
            $imagePath = $currentImages[$imageIndex] ?? null;
    
            if ($imagePath) {
                // Delete the image file from storage
                Storage::delete('public/'.$imagePath);
                // Remove the image from the current images array
                unset($currentImages[$imageIndex]);
                // Reindex the array
                $currentImages = array_values($currentImages);
            }
        }
    
        // **Handle Adding New Image**
        if ($request->hasFile('new_image')) {
            // Store the new image in the public/club-images directory
            $newImagePath = $request->file('new_image')->store('club-images', 'public');
    
            // Add the new image path to the current images array
            $currentImages[] = $newImagePath;
        }
    
        // Update the club with the new or modified image paths
        $club->club_image_paths = json_encode($currentImages); // Save updated image paths as JSON
    
        // Save the club and check if successful
        $status = $club->save();

        $route = '';
        if (currentAccount()->account_role != 3) {
            $route = route('committee-manage.edit-images', ['club_id' => $club->club_id]);
        } else {
            $route = route('admin-manage.edit-images', ['club_id' => $club->club_id]);
        }
    
        // Return with a success or error message
        return $status
            ? redirect($route)->with('success', 'Club images updated successfully!')
            : back()->withErrors(['club' => 'Failed to update club images. Please try again.']);
    }

    private function getFilters(Request $request) {
        // Fetch filters from form submission (may be empty if no checkboxes are selected)
        $filters = $request->input('category_filter', []);
    
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
                    ->whereIn('club_category', $filters);
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
        return [
            'club' => $this->clubService->getClubDetails($clubId),
            'clubMembers' => $this->clubService->getClubMembers($clubId),
            'clubEvents' => $this->eventService->getEventsForClub($clubId),
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'isCommitteeMember' => $this->clubService->checkCommitteeMember($clubId, profile()->profile_id)
        ];
    }
}
