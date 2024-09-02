<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profile')->insert([
            [
                'profile_id' => 1,
                'account_id' => 1,
                'profile_nickname' => '',
                'profile_personal_desc' => '',
                'profile_enrolment_session' => '2021/2022',
                'profile_faculty' => '',
                'profile_course' => '',
                'profile_picture_filepath' => '',
                'profile_colour_theme' => '',
            ],
            [
                'profile_id' => 2,
                'account_id' => 2,
                'profile_nickname' => '',
                'profile_personal_desc' => '',
                'profile_enrolment_session' => null,
                'profile_faculty' => '',
                'profile_course' => '',
                'profile_picture_filepath' => '',
                'profile_colour_theme' => '',
            ],
            [
                'profile_id' => 3,
                'account_id' => 3,
                'profile_nickname' => '',
                'profile_personal_desc' => '',
                'profile_enrolment_session' => null,
                'profile_faculty' => '',
                'profile_course' => '',
                'profile_picture_filepath' => '',
                'profile_colour_theme' => '',
            ],
        ]);
    }
}
