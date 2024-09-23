<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

    public function createUserPreference(Profile $profile) {
        UserPreference::create([
            'profile_id' => $profile->profile_id,
            'search_view_preference' => 1,
            'event_search_filters' => null,
            'club_search_filters' => null,
        ]);
    }

    public function prepareSystemUsersData($search = null) {
        // Fetch system users based on input. If empty, return all users
        $systemUsers = DB::table('account')
            ->select(
                'account.account_id',
                'account.account_full_name',
                'account.account_email_address',
                'account.account_role',
                'account.account_matric_number',
                'profile.profile_nickname',
                'profile.profile_enrolment_session',
                'profile.profile_faculty',
                'profile.profile_course',
                'profile.profile_picture_filepath'
            )
            ->join('profile', 'account.account_id', '=', 'profile.account_id')
            ->whereIn('account.account_role', [1, 2])
            ->when($search, function($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('account.account_full_name', 'like', "%{$search}%")
                    ->orWhere('account.account_email_address', 'like', "%{$search}%")
                    ->orWhere('account.account_matric_number', 'like', "%{$search}%");
                });
            })
            ->paginate(20);

        // Convert paginated result to collection and calculate role counts
        $systemUsersCollection = collect($systemUsers->items());
        $roleCounts = [
            'students' => $systemUsersCollection->where('account_role', 1)->count(),
            'facultyMembers' => $systemUsersCollection->where('account_role', 2)->count(),
        ];

        return [
            'systemUsers' => $systemUsers,
            'roleCounts' => $roleCounts
        ];
    }
}
