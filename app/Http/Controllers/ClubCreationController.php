<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClubService;

class ClubCreationController extends Controller
{
    protected $clubService;
    protected $notificationService;

    public function __construct(ClubService $clubService) {
        $this->clubService = $clubService;
    }

    public function addNewClub(Request $request) {
        return $this->clubService->handleAddNewClub($request);
    }

    public function makeNewClubCreationRequest(Request $request) {
        return $this->clubService->handleNewClubCreationRequest($request);
    }
}
