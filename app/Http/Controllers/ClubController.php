<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use App\Services\ClubAndEventService;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    protected $clubAndEventService;

    public function __construct(ClubAndEventService $clubAndEventService) {
        $this->clubAndEventService = $clubAndEventService;
    }

    public function fetchClubsFinder(Request $request) {
        // Handle POST request for filtering
        if ($request->isMethod('post')) {
            // Redirect to the GET route with query parameters for filters
            return redirect()->route('clubs-finder', $request->all());
        }

        $search = $request->input('search', '');
        $filters = $this->clubAndEventService->getClubFilters($request);
        $allClubs = $this->clubAndEventService->getAllClubs($filters, $search);
    
        return view('clubs-finder.general.view-all-clubs', [
            'clubs' => $allClubs,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'totalClubCount' => $allClubs->count(),
            'filters' => $filters,
            'search' => $search,
        ]);
    }

    public function clearFilterForGeneral() {
        $this->clubAndEventService->flushClubFilters();

        return redirect()->route('clubs-finder');
    }

    public function fetchClubDetailsForGeneral(Request $request) {
        $data = $this->clubAndEventService->prepareClubData($request->query('club_id'));
        
        // Return a view with the club details, events, members and view preference
        return view('clubs-finder.general.view-club-details', $data);
    }

    public function fetchClubsManager(Request $request) {
        if ($request->isMethod('post')) {
            return redirect()->route('manage-clubs', $request->all());
        }

        $search = $request->input('search', '');
        $filters = $this->clubAndEventService->getClubFilters($request);
        $allClubs = $this->clubAndEventService->getAllClubs($filters, $search);

        return view('clubs-finder.admin-manage.view-all-clubs', [
            'clubs' => $allClubs,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'totalClubCount' => $allClubs->count(),
            'filters' => $filters,
            'search' => $search,
        ]);
    }

    public function clearFilterForManager() {
        $this->clubAndEventService->flushClubFilters();
    
        return redirect()->route('manage-clubs');
    }

    public function fetchClubDetailsForManager(Request $request) {
        $data = $this->clubAndEventService->prepareClubData($request->query('club_id'));
        
        return view('clubs-finder.admin-manage.view-club-details', $data);
    }

    public function fetchAdminManagePage(Request $request) {
        $data = $this->clubAndEventService->prepareClubData($request->query('club_id'));

        return view('clubs-finder.admin-manage.manage-club-details', $data);
    }

    public function fetchCommitteeManagePage(Request $request) {
        $data = $this->clubAndEventService->prepareClubData($request->query('club_id'));

        return view('clubs-finder.committee-manage.manage-club-details', $data);
    }

    public function showClubInfoEditForAdmin(Request $request) {
        $data = $this->clubAndEventService->prepareClubData($request->query('club_id'));

        return view('clubs-finder.admin-manage.edit.club-info', [
            'club' => $data['club'],
        ]);
    }

    public function showClubInfoEditForCommittee(Request $request) {
        $data = $this->clubAndEventService->prepareClubData($request->query('club_id'));

        return view('clubs-finder.committee-manage.edit.club-info', [
            'club' => $data['club'],
        ]);
    }

    public function showClubImagesEditForAdmin(Request $request) {
        $data = $this->clubAndEventService->prepareClubData($request->query('club_id'));

        return view('clubs-finder.admin-manage.edit.images', [
            'club' => $data['club'],
        ]);
    }

    public function showClubImagesEditForCommittee(Request $request) {
        $data = $this->clubAndEventService->prepareClubData($request->query('club_id'));

        return view('clubs-finder.committee-manage.edit.images', [
            'club' => $data['club'],
        ]);
    }

    public function addNewClub(Request $request) {
        $validatedData = $request->validate([
            'new_club_name' => 'required|string|max:128',
            'new_club_category' => 'required|string',
            'new_club_description' => 'required|string|max:1024',
            'new_club_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the image upload, if present
        $imagePath = $request->hasFile('new_club_image')
            ? $request->file('new_club_image')->store('club-images', 'public')
            : '';

        $club = Club::create([
            'club_name' => $validatedData['new_club_name'],
            'club_category' => $validatedData['new_club_category'],
            'club_description' => $validatedData['new_club_description'],
            'club_image_paths' => json_encode($imagePath ? [$imagePath] : []),
        ]);

        return $club
            ? redirect()->route('manage-clubs.fetch-club-details', ['club_id' => $club->club_id])->with('success', 'New club added successfully!')
            : back()->withErrors(['error' => 'Failed to add new club. Please try again.']);
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

    public function addClubImage(Request $request) {
        // Validate if a new image is uploaded
        $request->validate([
            'new_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $club = Club::findOrFail($request->club_id);
        $currentImages = json_decode($club->getRawOriginal('club_image_paths'), true) ?? [];
        $newImagePath = $request->file('new_image')->store('club-images', 'public');
        $currentImages[] = $newImagePath;

        $club->club_image_paths = json_encode($currentImages); // Save updated image paths as JSON
        $status = $club->save();

        $route = '';
        if (currentAccount()->account_role != 3) {
            $route = route('committee-manage.edit-images', ['club_id' => $club->club_id]);
        } else {
            $route = route('admin-manage.edit-images', ['club_id' => $club->club_id]);
        }
    
        // Return with a success or error message
        return $status
            ? redirect($route)->with('success', 'Club image added successfully!')
            : back()->withErrors(['error' => 'Failed to add club image. Please try again.']);
    }

    public function deleteClubImage(Request $request) {
        $club = Club::findOrFail($request->club_id);
        $currentImages = json_decode($club->getRawOriginal('club_image_paths'), true) ?? [];
        $imageToDeleteIndex = $request->input('key');
        $imagePath = $currentImages[$imageToDeleteIndex] ?? null;

        if ($imagePath) {
            Storage::delete('public/'.$imagePath);
        }

        unset($currentImages[$imageToDeleteIndex]);
        $currentImages = array_values($currentImages);

        $club->club_image_paths = json_encode($currentImages);
        $status = $club->save();

        $route = '';
        if (currentAccount()->account_role != 3) {
            $route = route('committee-manage.edit-images', ['club_id' => $club->club_id]);
        } else {
            $route = route('admin-manage.edit-images', ['club_id' => $club->club_id]);
        }
    
        // Return with a success or error message
        return $status
            ? redirect($route)->with('success', 'Club image deleted successfully.')
            : back()->withErrors(['error' => 'Failed to delete club image. Please try again.']);
    }
}
