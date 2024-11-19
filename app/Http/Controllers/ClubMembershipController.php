<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClubService;
use App\Models\ClubMembership;
use Illuminate\Support\Facades\DB;

class ClubMembershipController extends Controller
{
    protected $clubService;

    public function __construct(ClubService $clubService) {
        $this->clubService = $clubService;
    }

    public function showClubMembersForAdmin(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubMembershipData($clubId);

        return view('clubs-finder.admin-manage.edit.members-access', [
            'club' => $data['club'],
            'clubMembers' => $data['clubMembers'],
            'joinRequests' => $data['joinRequests'],
            'isCommitteeMember' => $data['isCommitteeMember'],
        ]);
    }

    public function showClubMembersForCommittee(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubMembershipData($clubId);

        return view('clubs-finder.committee-manage.edit.members-access', [
            'club' => $data['club'],
            'clubMembers' => $data['clubMembers'],
            'joinRequests' => $data['joinRequests'],
            'isCommitteeMember' => $data['isCommitteeMember'],
        ]);
    }

    public function requestJoinClub(Request $request) {
        $profileId = $request->profile_id;
        $clubId = $request->club_id;

        $status = DB::table('club_membership')->insert([
            'profile_id' => $profileId,
            'club_id' => $clubId,
            'membership_type' => 0, // Assign 0 (request pending)
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $status
            ? redirect()->route('clubs-finder.fetch-club-details', ['club_id' => $clubId])->with('requested', 'Your request to join the club has been sent. The club will review your request soon.')
            : back()->withErrors(['error' => 'Failed to create join club request. Please try again.']);
    }

    // If the committee member accepts the join request, process as if the ClubMembership membership_type is updated to 1
    public function acceptJoinRequest(Request $request) {
        $profileId = $request->profile_id;
        $clubId = $request->club_id;

        $status = DB::table('club_membership')
            ->where('profile_id', $profileId)
            ->where('club_id', $clubId)
            ->update(['membership_type' => 1]);

        $route = '';
        if (currentAccount()->account_role != 3) {
            $route = route('committee-manage.edit-member-access', ['club_id' => $clubId]);
        } else {
            $route = route('admin-manage.edit-member-access', ['club_id' => $clubId]);
        }

        return $status
            ? redirect($route)
                ->with('accepted', 'User join request accepted.')
            : back()->withErrors(['error' => 'Failed to accept user join request. Please try again.']);
    }

    // If the committee member rejects the join request, process as if the ClubMembership record will be deleted
    public function rejectJoinRequest(Request $request) {
        $profileId = $request->profile_id;
        $clubId = $request->club_id;

        $status = ClubMembership::where('profile_id', $profileId)
            ->where('club_id', $clubId)
            ->delete();

        $route = '';
        if (currentAccount()->account_role != 3) {
            $route = route('committee-manage.edit-member-access', ['club_id' => $clubId]);
        } else {
            $route = route('admin-manage.edit-member-access', ['club_id' => $clubId]);
        }

        return $status
            ? redirect($route)
                ->with('rejected', 'User join request rejected.')
            : back()->withErrors(['error' => 'Failed to reject user join request. Please try again.']);
    }

    public function leaveClub(Request $request) {
        $profileId = $request->profile_id;
        $clubId = $request->club_id;

        $status = DB::table('club_membership')
            ->where('profile_id', $profileId)
            ->where('club_id', $clubId)
            ->delete();

        return $status
            ? redirect()->route('clubs-finder.fetch-club-details', ['club_id' => $clubId])->with('leave', 'You are no longer a member of this club.')
            : back()->withErrors(['error' => 'Failed to process leave club request. Please try again.']);
    }

    public function updateClubMemberAccess(Request $request) {
        $validatedData = $request->validate([
            'profile_id' => 'required|exists:club_membership,profile_id',
            'club_id' => 'required|exists:club_membership,club_id',
            'new_membership_type' => 'required|integer',
        ]);

        $status = DB::table('club_membership')
            ->where('profile_id', $validatedData['profile_id'])
            ->where('club_id', $validatedData['club_id'])
            ->update([
                'membership_type' => $validatedData['new_membership_type']
            ]);

        $route = '';
        if (currentAccount()->account_role != 3) {
            $route = route('committee-manage.edit-member-access', ['club_id' => $validatedData['club_id']]);
        } else {
            $route = route('admin-manage.edit-member-access', ['club_id' => $validatedData['club_id']]);
        }

        return $status
            ? redirect($route)->with('success', 'Member access level updated successfully.')
            : back()->withErrors(['error' => 'Failed to update member access level. Please try again.']);
    }

    private function prepareClubMembershipData($clubId) {
        return [
            'club' => $this->clubService->getClubDetails($clubId),
            'clubMembers' => $this->clubService->getClubMembers($clubId),
            'joinRequests' => $this->clubService->getJoinRequests($clubId),
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'isCommitteeMember' => $this->clubService->checkCommitteeMember($clubId, profile()->profile_id)
        ];
    }
}
