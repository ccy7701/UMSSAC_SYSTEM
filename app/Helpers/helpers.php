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
    function getUserSearchViewPreference($profile_id) {
        return UserPreference::where('profile_id', $profile_id)->value('search_view_preference');
    }
}
