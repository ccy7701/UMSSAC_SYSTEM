<?php

use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;

if (!function_exists('currentAccount')) {
    function currentAccount() {
        return Auth::user();
    }
}

if (!function_exists('profile')) {
    function profile() {
        return Auth::user()->profile;
    }
}

if (!function_exists('getUserSearchViewPreference')) {
    function getUserSearchViewPreference($profileId) {
        return UserPreference::where('profile_id', $profileId)->value('search_view_preference');
    }
}
