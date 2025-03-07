<?php

namespace App\Services;

use App\Models\Club;
use Illuminate\Http\Request;
use App\Models\ClubCreationRequest;
use App\Services\NotificationService;
use Carbon\Carbon;

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

        // Prepare the notifications to send to the admin
        $status = $this->notificationService->prepareClubCreationRequestNotifications($clubCreationRequest);

        return $status
            ? redirect()->route('club-creation.requests.view')
                ->with('sent', 'Your club creation request has been sent successfully. The system admin will review your request soon.')
            : back()->withErrors(['error' => 'Failed to submit club creation request. Please try again.']);
    }

    // Prepare all the data to be sent to the club creation requests view
    public function prepareAndRenderRequestsView(Request $request) {
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
        $query = null;

        // If the requestStatus is 1 and we need to include amended statuses, fetch both accepted and amended entries
        if ($requestStatus == 1 && $includeAmended) {
            $query = ClubCreationRequest::with(['profile.account'])->where('request_status', [1, 2]);
        } else {
            // Otherwise, fetch as normal
            $query = ClubCreationRequest::with(['profile.account'])->where('request_status', $requestStatus);
        }

        // If the account is FacultyMember, add to the query to match the current profile's profile ID
        if (currentAccount()->account_role == 2) {
            $query = $query->where('requester_profile_id', profile()->profile_id);
        }
    
        // Return the results ordered by updated_at
        return $query->orderBy('updated_at', 'desc')->get();
    }

    // Handle preparing the data to be sent to the request review page
    public function prepareAndRenderRequestReviewPage(Request $request) {
        $target = ClubCreationRequest::where('creation_request_id', $request->creation_request_id)->first();

        /**
         * For the case where the ADMIN accesses the page via the email,
         * but the request has already been reviewed,
         * redirect to the overview page instead.
         */
        if ($target->request_status != 0) {
            return redirect()->route('club-creation.requests.manage');
        }

        return view('clubs-finder.general.review-request', [
            'target' => $target,
        ]);
    }

    // Handle acceptance of the club creation request and then append to final Club table
    public function handleAcceptClubCreationRequest($request) {
        $target = ClubCreationRequest::where('creation_request_id', $request->creation_request_id)->first();
        
        // Update the request status and updated timestamp
        $target->request_status = 1;
        $target->updated_at = Carbon::now();

        // Save the updated data
        $target->save();

        // Then, create a new Club instance and append it to the 'club' table
        $club = Club::create([
            'club_name' => $target->club_name,
            'club_category' => $target->club_category,
            'club_description' => $target->club_description,
            'club_image_paths' => json_encode([]),
        ]);

        // Then send email after update
        $status = $this->notificationService->prepareClubCreationAcceptNotifications($target, $club);

        return $status
            ? redirect(route('club-creation.requests.manage'))->with('accepted', 'Club creation request for ' . $target->club_name . ' marked as accepted.')
            : back()->withErrors(['error' => 'Failed to mark club creation request for ' . $target->club_name . ' as accepted. Please try again.']);
    }

    // Handle rejection of the club creation request
    public function handleRejectClubCreationRequest(Request $request) {
        $target = ClubCreationRequest::where('creation_request_id', $request->creation_request_id)->first();

        // Update the request status, remarks, and updated timestamp
        $target->request_status = 3;
        $target->request_remarks = $request->request_remarks;
        $target->updated_at = Carbon::now();

        // Save the updated data
        $target->save();

        // Send email after update
        $status = $this->notificationService->prepareClubCreationRejectNotifications($target);

        return $status
            ? redirect(route('club-creation.requests.manage'))->with('rejected', 'Club creation request for ' . $target->club_name . ' marked as rejected.')
            : back()->withErrors(['error' => 'Failed to mark club creation request for ' . $target->club_name . ' as rejected. Please try again.']);
    }
}
