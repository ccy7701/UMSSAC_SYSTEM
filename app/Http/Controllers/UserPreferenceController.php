<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPreferenceController extends Controller
{
    public function updateItemViewPreference(Request $request) {
        $request->validate([
            'search_view_preference' => 'required|in:1,2',
        ]);
        DB::table('user_preference')
            ->where('profile_id', profile()->profile_id)
            ->update(['search_view_preference' => $request->input('search_view_preference'), 'updated_at' => now()]);

        return response()->json(['status' => 'success']);
    }
}
