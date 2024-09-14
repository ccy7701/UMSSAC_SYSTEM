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
            'isCommitteeMember' => $data['isCommitteeMember'],
        ]);
    }

    public function showClubMembersForCommittee(Request $request) {
        $clubId = $request->query('club_id');
        $data = $this->prepareClubMembershipData($clubId);

        return view('clubs-finder.committee-manage.edit.members-access', [
            'club' => $data['club'],
            'clubMembers' => $data['clubMembers'],
            'isCommitteeMember' => $data['isCommitteeMember'],
        ]);
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
            // ROUTE TO BE ADDED LATER!
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
            'searchViewPreference' => getUserSearchViewPreference(profile()->profile_id),
            'isCommitteeMember' => $this->clubService->checkCommitteeMember($clubId, profile()->profile_id)
        ];
    }
}
