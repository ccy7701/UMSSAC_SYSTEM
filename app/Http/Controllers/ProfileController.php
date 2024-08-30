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
            'newProfilePicture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Assuming you have the authenticated user's profile
        $profile = Profile::where('accountID', Auth::user()->accountID)->firstOrFail();

        // Store the new profile picture
        if ($request->hasFile('newProfilePicture')) {
            // Delete the old picture if it exists
            if ($profile->profilePictureFilePath) {
                Storage::delete('public/'.$profile->profilePictureFilePath);
            }

            // Store the new picture in public/profile-pictures
            $path = $request->file('newProfilePicture')->store('profile-pictures', 'public');

            // Update profile with new file path
            $profile->profilePictureFilePath = $path;
            $profile->save();
        }

        return redirect()->route('profile')->with('success', 'Profile picture updated successfully!');
    }
}
