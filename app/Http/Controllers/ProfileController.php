<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
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
                ? redirect()->route('my-profile')->with('success', 'Profile picture updated successfully!')
                : back()->withErrors(['my-profile' => 'Failed to update profile picture. Please try again.']);
        }
    }

    // Update general info
    public function updateGeneralInfo(Request $request) {
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
}
