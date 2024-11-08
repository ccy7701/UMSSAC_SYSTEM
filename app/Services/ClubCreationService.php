<?php

namespace App\Services;

use App\Models\Club;
use Illuminate\Http\Request;
use App\Models\ClubCreationRequest;
use App\Services\NotificationService;

class ClubCreationService
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
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

    // Handle creating new club request
    public function handleNewClubCreationRequest(Request $request) {
        $validatedData = $request->validate([
            'new_club_name' => 'required|string|max:128',
            'new_club_category' => 'required|string',
            'new_club_description' => 'required|string|max:1024',
            'new_club_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->hasFile('new_club_image')
            ? $request->file('new_club_image')->store('club-request-images', 'public')
            : '';

        $clubCreationRequest = ClubCreationRequest::create([
            'requester_profile_id' => $request->requester_profile_id,
            'club_name' => $validatedData['new_club_name'],
            'club_category' => $validatedData['new_club_category'],
            'club_description' => $validatedData['new_club_description'],
            'club_image_paths' => json_encode($imagePath ? [$imagePath] : []),
            'request_status' => 0,
            'request_remarks' => '',
        ]);

        // Send email after creation
        $status = $this->notificationService->prepareClubCreationRequestEmail($clubCreationRequest);

        return $status
            ? redirect()->route('club-creation.requests.new')
                ->with('success', 'Your club creation request has been sent successfully. The system admin will review your request soon.')
            : back()->withErrors(['error' => 'Failed to submit club creation request. Please try again.']);
    }

    // Prepare all the data to be sent to the club creation requests view
    public function prepareAndRenderRequestsView() {
        $viewName = null;
        if (currentAccount()->account_role == 3) {
            $viewName = 'clubs-finder.admin-manage.view-club-creation-requests';
        } elseif (currentAccount()->account_role == 2) {
            $viewName = 'clubs-finder.general.view-club-creation-requests';
        }

        // Fetch the requests arranged by status
        // Note: accepted requests includes full accept and amended accept
        $pendingRequests = $this->getClubCreationRequestsByStatus(0);
        $acceptedRequests = $this->getClubCreationRequestsByStatus(1, 'include_amended');
        $rejectedRequests = $this->getClubCreationRequestsByStatus(3);

        return view($viewName, [
            'pendingRequests' => $pendingRequests,
            'pendingCount' => $pendingRequests->count(),
            'acceptedRequests' => $acceptedRequests,
            'acceptedCount' => $acceptedRequests->count(),
            'rejectedRequests' => $rejectedRequests,
            'rejectedCount' => $rejectedRequests->count()
        ]);
    }

    /**
     * Get the club creation requests by status.
     * 0 - pending, 1 - accepted, 2 - accepted with amendment, 3 = rejected
     */
    private function getClubCreationRequestsByStatus($requestStatus, $includeAmended = null) {
        $query = ClubCreationRequest::where('request_status', $requestStatus);

        if ($requestStatus == 1 && $includeAmended) {
            $query = ClubCreationRequest::whereIn('request_status', [1, 2]);
        }

        return $query->get();
    }
}
