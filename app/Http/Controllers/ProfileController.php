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
            $profile->save();
        }

        return redirect()->route('profile')->with('success', 'Profile picture updated successfully!');
    }

    // Update general info
    public function updateGeneralInfo(Request $request) {
        // Log the incoming request data for debugging purposes
        // Log::info('Received update request:', $request->all());

        // Custom validation messages
        $messages = [
            'profile_enrolment_session.required_if' => 'The profile enrolment session field is required.',
        ];

        // Validate the incoming request data
        $validatedData = $request->validate([
            'profile_faculty' => 'required|string|max:255',
            'profile_programme' => 'required|string|max:255',
            'profile_nickname' => 'required|string|max:255',
            'profile_enrolment_session' => 'required_if:account_role,1|nullable|string',
        ], $messages);

        // Assuming you have the authenticated user's profile
        $profile = Profile::where('account_id', currentAccount()->account_id)->firstOrFail();

        // Explicitly handle the profile_enrolment_session if it's missing (for account_role != 1)
        if ($request->input('account_role') != 1) {
            $validatedData['profile_enrolment_session'] = null;
        }

        // Update the profile with the validated data
        $profile->update($validatedData);

        // Optionally, flash a success message to the session
        // session()->flash('success', 'Profile information updated successfulyl!');

        // Redirect back to the form or another page
        return redirect()->route('profile')->with('success', 'General info updated succesfully!');
    }
}
