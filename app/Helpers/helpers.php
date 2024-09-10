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

if (!function_exists('getUserSearchViewPreference')) {
    function getUserSearchViewPreference($profile_id) {
        return UserPreference::where('profile_id', $profile_id)->value('search_view_preference');
    }
}

if (!function_exists('getUserClubSearchFilters')) {
    function getUserClubSearchViewFilters($profile_id) {
        $filters = UserPreference::where('profile_id', $profile_id)->value('club_search_filters');
        return json_decode($filters, true);
    }
}
