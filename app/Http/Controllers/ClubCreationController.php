<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClubCreationService;

class ClubCreationController extends Controller
{
    protected $clubCreationService;

    public function __construct(ClubCreationService $clubCreationService) {
        $this->clubCreationService = $clubCreationService;
    }

    public function addNewClub(Request $request) {
        return $this->clubCreationService->handleAddNewClub($request);
    }

    public function makeNewClubCreationRequest(Request $request) {
        return $this->clubCreationService->handleNewClubCreationRequest($request);
    }

    public function fetchRequestsPage(Request $request) {
        return $this->clubCreationService->prepareAndRenderRequestsView($request);
    }

    public function rejectCreationRequest(Request $request) {
        return $this->clubCreationService->handleRejectClubCreationRequest($request);
    }
}
