<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ClubService;
use App\Services\NotificationService;

class ClubCreationController extends Controller
{
    protected $clubService;
    protected $notificationService;

    public function __construct(ClubService $clubService, NotificationService $notificationService) {
        $this->clubService = $clubService;
        $this->notificationService = $notificationService;
    }

    public function addNewClub(Request $request) {
        return $this->clubService->handleAddNewClub($request);
    }
}
