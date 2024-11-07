<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClubService;

class ClubController extends Controller
{
    protected $clubService;

    public function __construct(ClubService $clubService) {
        $this->clubService = $clubService;
    }

    public function fetchClubsFinder(Request $request) {
        return $this->clubService->prepareAndRenderClubsFinderView($request);
    }

    public function clearFilterForGeneral() {
        return $this->clubService->flushClubFilters('clubs-finder');
    }
    
    public function fetchClubDetailsForGeneral(Request $request) {
        return view(
            'clubs-finder.general.view-club-details',
            $this->clubService->prepareClubData($request->query('club_id'))
        );
    }

    public function fetchClubsManager(Request $request) {
        return $this->clubService->prepareAndRenderClubsFinderView($request, 1);
    }

    public function clearFilterForManager() {
        return $this->clubService->flushClubFilters('manage-clubs');
    }

    public function fetchClubDetailsForManager(Request $request) {
        return view(
            'clubs-finder.admin-manage.view-club-details',
            $this->clubService->prepareClubData($request->query('club_id'))
        );
    }

    public function fetchAdminManagePage(Request $request) {
        return view(
            'clubs-finder.admin-manage.manage-club-details',
            $this->clubService->prepareClubData($request->query('club_id'))
        );
    }

    public function fetchCommitteeManagePage(Request $request) {
        return view(
            'clubs-finder.committee-manage.manage-club-details',
            $this->clubService->prepareClubData($request->query('club_id'), 1)
        );
    }

    public function showClubInfoEditForAdmin(Request $request) {
        $data = $this->clubService->prepareClubData($request->query('club_id'));

        return view('clubs-finder.admin-manage.edit.club-info', [
            'club' => $data['club'],
        ]);
    }

    public function showClubInfoEditForCommittee(Request $request) {
        $data = $this->clubService->prepareClubData($request->query('club_id'));

        return view('clubs-finder.committee-manage.edit.club-info', [
            'club' => $data['club'],
        ]);
    }

    public function showClubImagesEditForAdmin(Request $request) {
        $data = $this->clubService->prepareClubData($request->query('club_id'));

        return view('clubs-finder.admin-manage.edit.images', [
            'club' => $data['club'],
        ]);
    }

    public function showClubImagesEditForCommittee(Request $request) {
        $data = $this->clubService->prepareClubData($request->query('club_id'));

        return view('clubs-finder.committee-manage.edit.images', [
            'club' => $data['club'],
        ]);
    }

    public function fetchJoinedClubs(Request $request) {
        return $this->clubService->prepareAndRenderJoinedClubsView($request);
    }

    public function updateClubInfo(Request $request) {
        return $this->clubService->handleUpdateClubInfo($request);
    }

    public function addClubImage(Request $request) {
        return $this->clubService->handleAddClubImage($request);
    }

    public function deleteClubImage(Request $request) {
        return $this->clubService->handleDeleteClubImage($request);
    }

    public function sendEmailTest() {
        return $this->clubService->handleClubEmailTest();
    }
}
