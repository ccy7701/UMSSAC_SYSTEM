<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertSeederData(1, [
            [
                'search_view_preference' => 1,
                'event_search_filters' => null,
                'club_search_filters' => null,
                'users_search_filters' => null,
            ]
        ]);

        $this->insertSeederData(2, [
            [
                'search_view_preference' => 2,
                'event_search_filters' => null,
                'club_search_filters' => null,
                'users_search_filters' => null,
            ]
        ]);

        $this->insertSeederData(3, [
            [
                'search_view_preference' => 1,
                'event_search_filters' => null,
                'club_search_filters' => null,
                'users_search_filters' => null,
            ]
        ]);
    }

    // Helper function to insert user preferences data
    private function insertSeederData(int $profileId, array $userPreferences): void
    {
        $data = array_map(function ($userPreference) use ($profileId) {
            return array_merge(
                [
                    'profile_id' => $profileId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                $userPreference
            );
        }, $userPreferences);
        DB::table('user_preference')->insert($data);
    }
}
