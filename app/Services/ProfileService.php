<?php

namespace App\Services;

use App\Models\Club;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    // Handle updating the user's profile general info
    public function handleUpdateGeneralInfo(Request $request) {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'profile_personal_desc' => 'max:1024',
            'profile_faculty' => 'nullable|string|max:16',
            'profile_course' => 'nullable|string|max:255',
            'profile_nickname' => 'nullable|string|max:255',
        ]);

        // Assuming you have the authenticated user's profile
        $profile = Profile::where('account_id', currentAccount()->account_id)->firstOrFail();

        // Update the profile with the validated data
        $status = $profile->update($validatedData);

        // Redirect back with a success message
        return $status
            ? redirect()->route('my-profile')->with('success', 'General info updated successfully!')
            : back()->withErrors(['my-profile' => 'Failed to update the general info. Please try again.']);
    }

    // Handle updating the user's profile picture
    public function handleUpdateProfilePicture(Request $request) {
        $request->validate([
            'new_profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Assuming you have the authenticated user's profile
        $profile = Profile::where('account_id', currentAccount()->account_id)->firstOrFail();

        // Store the new profile picture
        if ($request->hasFile('new_profile_picture')) {
            // Delete the old picture if it exists
            if ($profile->profile_picture_filepath) {
                Storage::delete('public/'.$profile->profile_picture_filepath);
            }

            // Store the new picture in public/profile-pictures
            $path = $request->file('new_profile_picture')->store('profile-pictures', 'public');

            // Update profile with new file path
            $profile->profile_picture_filepath = $path;
            $status = $profile->save();

            return $status
                ? redirect()->route('my-profile')->with('success', 'Profile picture updated successfully!')
                : back()->withErrors(['my-profile' => 'Failed to update profile picture. Please try again.']);
        }
    }

    // Prepare all the data to be sent to the profile view
    public function prepareAndRenderUserProfileView(Request $request) {
        $profile = $this->getUserProfile($request->profile_id);
        $joinedClubs = $this->getUserJoinedClubs($request->profile_id);

        return view('profile.view-user-profile', [
            'profile' => $profile,
            'joinedClubs' => $joinedClubs,
        ]);
    }

    // Get the user profile
    private function getUserProfile($profileId) {
        $profile = Profile::where('profile_id', $profileId)
        ->with([
            'account' => function($query) {
                $query->select(
                    'account_id',
                    'account_full_name',
                    'account_email_address',
                    'account_contact_number',
                    'account_role',
                    'account_matric_number'
                );
            }
        ])
        ->first();

        // Prepare the profile data before sending it back
        $profile->profile_nickname = $profile->profile_nickname != ''
            ? $profile->profile_nickname
            : 'No nickname';
        $profile->profile_enrolment_session = $profile->profile_enrolment_session
            ? $profile->profile_enrolment_session
            : 'Not filled yet';
        $profile->profile_faculty = $profile->profile_faculty
            ? $profile->profile_faculty
            : 'Unspecified';
        $profile->profile_personal_desc = $profile->profile_personal_desc
            ? $profile->profile_personal_desc
            : 'No personal description written yet';
        $profile->profile_course = $profile->profile_course
            ? $profile->profile_course
            : null;

        return $profile;
    }

    // Get the clubs that the user is currently a member in
    private function getUserJoinedClubs($profileId) {
        return Club::whereIn('club_id', function ($query) use ($profileId) {
            $query->select('club_id')
                ->from('club_membership')
                ->where('profile_id', $profileId);
        })->get();
    }
}
