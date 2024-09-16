<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Club;
use App\Models\Event;
use Illuminate\Database\Seeder;

class ClubEventMixedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Club::factory()
            ->count(5)
            ->create()
            ->each(function ($club) {
                Event::factory()
                    ->count(5)
                    ->create([
                        'club_id' => $club->club_id,
                    ]);
            });
    }
}
