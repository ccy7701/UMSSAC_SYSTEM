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
        $this->insertSeederData(1);
        $this->insertSeederData(2);
        $this->insertSeederData(3);
        $this->insertSeederData(4);
        $this->insertSeederData(5);
        $this->insertSeederData(6);
        $this->insertSeederData(7);
        $this->insertSeederData(8);
        $this->insertSeederData(9);
        $this->insertSeederData(10);
        $this->insertSeederData(11);
        $this->insertSeederData(12);
        $this->insertSeederData(13);
        $this->insertSeederData(14);
        $this->insertSeederData(15);
        $this->insertSeederData(16);
        $this->insertSeederData(17);
        $this->insertSeederData(18);
    }

    // Helper function to insert user preferences data
    private function insertSeederData($profileId) {
        $data = [
            'profile_id' => $profileId,
            'search_view_preference' => 1,
            'event_search_filters' => null,
            'club_search_filters' => null,
            'users_search_filters' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table('user_preference')->insert($data);
    }
}
