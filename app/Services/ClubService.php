<?php

namespace App\Services;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\ClubMembership;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClubService
{
    protected $bookmarkService;

    public function __construct(BookmarkService $bookmarkService) {
        $this->bookmarkService = $bookmarkService;
    }

    // Prepare all the data to be sent to the clubs finder view
    public function prepareAndRenderClubsFinderView(Request $request) {
        $route = currentAccount()->account_role != 3 ? 'clubs-finder' : 'manage-clubs';
        $viewName = currentAccount()->account_role != 3
            ? 'clubs-finder.general.view-all-clubs'
            : 'clubs-finder.admin-manage.view-all-clubs';

        // Handle POST request for filtering
        if ($request->isMethod('post')) {
            $filters = $request->input('category_filter', []);
            if (empty($filters)) {
                $this->flushClubFilters();
            } else {
                $this->updateClubFilters($filters);
            }
            // Redirect to the GET route with query parameters for filters
            return redirect()->route($route, $request->all());
        }

        $search = $request->input('search', '');
        $filters = $this->getClubFilters();
        $allClubs = $this->getAllClubs($filters, $search);
    
        return view($viewName, [
            'clubs' => $allClubs,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'totalClubCount' => $allClubs->count(),
            'filters' => $filters,
            'search' => $search
        ]);
    }

    // Get the user's CLUB category and search filters
    public function getClubFilters() {
        $savedFilters = DB::table('user_preference')
                ->where('profile_id', profile()->profile_id)
                ->value('club_search_filters');

        return $savedFilters ? json_decode($savedFilters, true) : [];
    }

    // Update the user's club filters
    public function updateClubFilters(array $filters) {
        return DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'club_search_filters' => json_encode($filters),
                'updated_at' => now()
            ]);
    }

    // Flush (clear all) of the user's CLUB search filters
    public function flushClubFilters($route = null) {
        // Clear the filters for the authenticated user's profile
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'club_search_filters' => json_encode([]),
                'updated_at' => now()
            ]);

        if ($route) {
            return redirect()->route($route);
        }
    }

    // Get all clubs
    public function getAllClubs(array $filters, $search = null) {
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
            ->paginate(12);
    }

    // Prepare all data for the specific club
    public function prepareClubData($clubId) {
        $clubEvents = $this->getEventsForClub($clubId);

        // Find intersection between all club eventIDs and bookmarked eventIDs
        $bookmarkedEventIDs = $this->bookmarkService->getBookmarkedEventIDs();
        $allClubEventIDs = $clubEvents['eventIDs'];
        $intersectionArray = array_values(array_intersect($allClubEventIDs, $bookmarkedEventIDs));
        
        return [
            'club' => $this->getClubDetails($clubId),
            'clubMembers' => $this->getClubMembers($clubId),
            'clubMembersCount' => $this->getClubMembersCount($clubId),
            'clubEvents' => $clubEvents['clubEvents'],
            'intersectionArray' => $intersectionArray,
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'isCommitteeMember' => $this->checkCommitteeMember($clubId, profile()->profile_id)
        ];
    }

    // Get the profiles (students, faculty members) inside the club
    public function getClubMembers($clubId) {
        $currentProfileId = profile()->profile_id;

        return ClubMembership::where('club_id', $clubId)
            ->with(['profile.account'])
            ->orderByRaw("CASE WHEN profile_id = ? THEN 0 ELSE 1 END", [$currentProfileId])
            ->orderBy('membership_type', 'desc')
            ->paginate(8);
    }

    // Get the count of members of the specific club
    public function getClubMembersCount($clubId) {
        return ClubMembership::where('club_id', $clubId)->count();
    }

    // Get all the events of the specific club
    public function getEventsForClub($club_id) {
        $clubEvents = Event::where('club_id', $club_id)->paginate(12);
        $eventIDs = $clubEvents->pluck('event_id')->toArray();

        return compact('clubEvents', 'eventIDs');
    }

    // Get the details of the specific club
    public function getClubDetails($clubId) {
        return Club::findOrFail($clubId);
    }

    // Check and determine if the current user is a committee member of the club
    public function checkCommitteeMember($clubId, $profileId) {
        return ClubMembership::where('club_id', $clubId)
            ->where('profile_id', $profileId)
            ->where('membership_type', 2)
            ->exists();
    }

    // Handle adding new club
    public function handleAddNewClub(Request $request) {
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

    // Handle editing the club info
    public function handleUpdateClubInfo(Request $request) {
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

    // Handle adding club image
    public function handleAddClubImage(Request $request) {
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

    // Handle deleting club image
    public function handleDeleteClubImage(Request $request) {
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
