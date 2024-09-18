<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimetableSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertSeederData(1, [
            [
                'subject_code' => 'KK45103',
                'name' => 'Software Evolution Management',
                'category' => 'lecture',
                'section' => 1,
                'location' => 'DKP 14',
                'day' => 2,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
            ],
            [
                'subject_code' => 'KK12345',
                'name' => 'SE Tutorial',
                'category' => 'tutorial',
                'section' => 1,
                'location' => 'DKP 15',
                'day' => 3,
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
            ],
            [
                'subject_code' => 'GB30603',
                'name' => 'Islamic Finance and Banking',
                'category' => 'lecture',
                'section' => 1,
                'location' => 'Online',
                'day' => 5,
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
            ]
        ]);
    }

    public function insertSeederData(int $profileId, array $classData): void
    {
        $data = array_map(function ($class) use ($profileId) {
            return array_merge([
                'profile_id' => $profileId,
                'class_subject_code' => $class['subject_code'],
                'class_name' => $class['name'],
                'class_category' => $class['category'],
                'class_section' => $class['section'],
                'class_location' => $class['location'],
                'class_day' => $class['day'],
                'class_start_time' => $class['start_time'],
                'class_end_time' => $class['end_time'],
            ]);
        }, $classData);

        DB::table('timetable_slot')->insert($data);
    }
}
