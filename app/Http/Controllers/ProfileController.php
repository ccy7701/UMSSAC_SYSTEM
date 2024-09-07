<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Update profile picture
    public function updateProfilePicture(Request $request) {
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
                ? redirect()->route('profile')->with('success', 'Profile picture updated successfully!')
                : back()->withErrors(['profile' => 'Failed to update profile picture. Please try again.']);
        }
    }

    // Update general info
    public function updateGeneralInfo(Request $request) {
        // Custom validation messages
        $messages = [
            'profile_enrolment_session.required_if' => 'The profile enrolment session field is required.',
        ];

        // Validate the incoming request data
        $validatedData = $request->validate([
            'profile_personal_desc' => 'max:1024',
            'profile_enrolment_session' => 'required_if:account_role,1|nullable|string',
            'profile_faculty' => 'required|string|max:16',
            'profile_course' => 'required|string|max:255',
            'profile_nickname' => 'required|string|max:255',
        ], $messages);

        // Assuming you have the authenticated user's profile
        $profile = Profile::where('account_id', currentAccount()->account_id)->firstOrFail();

        // Explicitly handle the profile_enrolment_session if it's missing (for account_role != 1)
        if ($request->input('account_role') != 1) {
            $validatedData['profile_enrolment_session'] = null;
        }

        // Update the profile with the validated data
        $status = $profile->update($validatedData);

        // Redirect back with a success message
        return $status
            ? redirect()->route('profile')->with('success', 'General info updated successfully!')
            : back()->withErrors(['profile' => 'Failed to update the general info. Please try again.']);
    }
}
