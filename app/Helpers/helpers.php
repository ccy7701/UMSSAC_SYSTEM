<?php

use Illuminate\Support\Facades\Auth;
use App\Models\UserPreference;

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

if (!function_exists('userPreference')) {
    function getUserSearchViewPreference($profile_id) {
        return UserPreference::where('profile_Id', $profile_id)->value('search_view_preference');
    }
}