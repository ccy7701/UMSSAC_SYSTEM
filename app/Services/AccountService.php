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

    public function getAllSystemUsers(array $filters, $search = null) {
        // Always save the filters, event if empty (to clear the saved filters)
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'users_search_filters' => json_encode($filters),
                'updated_at' => now()
            ]);

        // Fetch system users based on the filters (if empty, return all) and search input
        return Account::join('profile', 'account.account_id', '=', 'profile.account_id')
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
            ->when(!empty($filters), function ($query) use ($filters) {
                return $query->where(function ($q) use ($filters) {
                    foreach ($filters as $category) {
                        // Handle the case where the category is 'Unspecified'
                        if ($category === 'Unspecified') {
                            $q->orWhere('profile.profile_faculty', '');
                        } else {
                            $q->orWhere('profile.profile_faculty', $category);
                        }
                    }
                });
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('account.account_full_name', 'like', "%{$search}%")
                    ->orWhere('account.account_email_address', 'like', "%{$search}%")
                    ->orWhere('account.account_matric_number', 'like', "%{$search}%");
                });
            })
            ->whereIn('account.account_role', [1, 2])
            ->orderBy('account_role', 'desc')
            ->paginate(20);
    }

    // Get the admin's USERS category and search filters
    public function getUsersSearchFilters(Request $request) {
        $filters = $request->input('category_filter', []);

        if (empty($filters)) {
            $savedFilters = DB::table('user_preference')
                ->where('profile_id', profile()->profile_id)
                ->value('users_search_filters');
            $filters = $savedFilters ? json_decode($savedFilters, true) : [];
        }

        return $filters;
    }

    // Flush (clear all) of the admin's USERS search filters
    public function flushUsersSearchFilters() {
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update([
                'users_search_filters' => json_encode([]),
                'updated_at' => now()
            ]);
    }
}
