<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('club')->insert([
            [
                'club_id' => 1,
                'club_name' => 'Coffee Drinking Club',
                'club_category' => 'FKIKK',
                'club_description' => 'We drink and learn about many types of coffess.',
                'club_image_paths' => json_encode([]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'club_id' => 2,
                'club_name' => 'Xianzhou Alliance',
                'club_category' => 'FPP',
                'club_description' => 'An ancient, space-faring civilisation following the Aeon Lan and a major faction in Honkai: Star Rail.',
                'club_image_paths' => json_encode([]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
