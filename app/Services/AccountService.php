<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Profile;
use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountService
{
    public function createAccount(Request $request) {
        return Account::create([
            'account_full_name' => $request->account_full_name,
            'account_email_address' => $request->account_email_address,
            'account_password' => Hash::make($request->account_password),
            'account_role' => $request->account_role,
            'account_matric_number' => $request->account_role == 1 ? $request->account_matric_number : null,
        ]);
    }

    public function createProfile(Request $request, Account $account) {
        return Profile::create([
            'account_id' => $account->account_id,
            'profile_nickname' => '',
            'profile_personal_desc' => '',
            'profile_enrolment_session' => $request->account_role == 1 ? '' : null,
            'profile_faculty' => '',
            'profile_course' => '',
            'profile_picture_filepath' => '',
            'profile_colour_theme' => '',
        ]);
    }

    // KEEP IN VIEW
    public function createUserPreference(Profile $profile) {
        UserPreference::create([
            'profile_id' => $profile->profile_id,
            'search_view_preference' => 1,
            'event_search_filters' => null,
            'club_search_filters' => null,
        ]);
    }
}
