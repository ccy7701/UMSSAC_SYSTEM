<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AccountSeeder::class,
            ProfileSeeder::class,
            SemesterProgressLogSeeder::class,
            SubjectStatsLogSeeder::class,
            ClubSeeder::class,
            EventSeeder::class,
            UserPreferenceSeeder::class,
            ClubMembershipSeeder::class,
            ClubEventMixedSeeder::class,
            TimetableSlotSeeder::class,
            UserTraitsRecordSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
