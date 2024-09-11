<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubMembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertSeederData(1, 1, 1);
        $this->insertSeederData(1, 2, 1);
        $this->insertSeederData(2, 1, 2);
    }

    // Helper function to insert club membership data
    private function insertSeederData(int $profile_id, int $club_id, int $membership_type): void
    {
        DB::table('club_membership')->insert([
            'profile_id' => $profile_id,
            'club_id' => $club_id,
            'membership_type' => $membership_type,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
