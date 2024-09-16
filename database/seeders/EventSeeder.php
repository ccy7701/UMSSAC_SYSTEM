<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('event')->insert([
            // Event 1: Coffee drinking club
            [
                'event_id' => 1,
                'club_id' => 1,
                'event_name' => 'Coffee Brewing Techniques Workshop',
                'event_location' => 'Coffee Shop',
                'event_datetime' => Carbon::now(),
                'event_description' => 'Learn the art of brewing the perfect cup of coffee. From espresso to pour-over, this workshop will cover it all!',
                'event_entrance_fee' => 15.00,
                'event_sdp_provided' => 1,
                'event_image_paths' => json_encode([]),
                'event_registration_link' => 'https://coffeeclub.com/register/1',
                'event_status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Event 2: Xianzhou Alliance
            [
                'event_id' => 2,
                'club_id' => 2,
                'event_name' => 'Intergalactic Strategy Symposium',
                'event_location' => 'Stargazer Navalia, Xianzhou Luofu',
                'event_datetime' => Carbon::now(),
                'event_description' => 'Join the Xianzhou Alliance for strategy discussions.',
                'event_entrance_fee' => 0.00,
                'event_sdp_provided' => 0,
                'event_image_paths' => json_encode([]),
                'event_registration_link' => 'https://xianzhouclub.com/register/1',
                'event_status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
