<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClubMembershipService;

class ClubMembershipController extends Controller
{
    protected $clubMembershipService;

    public function __construct(ClubMembershipService $clubMembershipService) {
        $this->clubMembershipService = $clubMembershipService;
    }

    public function showClubMembersForAdmin(Request $request) {
        return $this->clubMembershipService->prepareClubMembersForAdmin($request);
    }

    public function showClubMembersForCommittee(Request $request) {
        return $this->clubMembershipService->prepareClubMembersForCommittee($request);
    }

    public function requestJoinClub(Request $request) {
        return $this->clubMembershipService->handleCreateJoinRequest($request);
    }

    public function acceptJoinRequest(Request $request) {
        return $this->clubMembershipService->handleAcceptJoinRequest($request);
    }

    public function rejectJoinRequest(Request $request) {
        return $this->clubMembershipService->handleRejectJoinRequest($request);
    }

    public function leaveClub(Request $request) {
        return $this->clubMembershipService->handleLeaveClub($request);
    }

    public function updateClubMemberAccess(Request $request) {
        return $this->clubMembershipService->handleUpdateClubMemberAccess($request);
    }
}
