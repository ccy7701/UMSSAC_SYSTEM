<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateProfilePicture(Request $request) {
        $request->validate([
            'new_profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Assuming you have the authenticated user's profile
        $profile = Profile::where('account_id', Auth::user()->account_id)->firstOrFail();

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
}
