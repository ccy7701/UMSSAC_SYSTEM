<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;
    
    public function __construct(ProfileService $profileService) {
        $this->profileService = $profileService;
    }
    
    public function updateProfilePicture(Request $request) {
        return $this->profileService->handleUpdateProfilePicture($request);
    }

    public function updateGeneralInfo(Request $request) {
        return $this->profileService->handleUpdateGeneralInfo($request);
    }

    public function fetchUserProfile(Request $request) {
        return $this->profileService->prepareAndRenderUserProfileView($request);
    }
}
