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
                'class_subject_code' => 'KK45103',
                'class_name' => 'Software Evolution Management',
                'class_category' => 'lecture',
                'class_section' => 1,
                'class_lecturer' => 'Dr. John Doe',
                'class_location' => 'DKP 14',
                'class_day' => 2,
                'class_start_time' => '08:00:00',
                'class_end_time' => '10:00:00',
            ],
            [
                'class_subject_code' => 'KK12345',
                'class_name' => 'SE Course Tutorial',
                'class_category' => 'tutorial',
                'class_section' => 1,
                'class_lecturer' => 'Dr. Jane Doe',
                'class_location' => 'DKP 15',
                'class_day' => 3,
                'class_start_time' => '10:00:00',
                'class_end_time' => '12:00:00',
            ],
            [
                'class_subject_code' => 'GB30603',
                'class_name' => 'Islamic Finance and Banking',
                'class_category' => 'lecture',
                'class_section' => 1,
                'class_lecturer' => 'Dr. Juan Doe',
                'class_location' => 'Online',
                'class_day' => 5,
                'class_start_time' => '14:00:00',
                'class_end_time' => '16:00:00',
            ]
        ]);
    }

    public function insertSeederData(int $profileId, array $timetableSlots): void
    {
        $data = array_map(function ($log, $index) use ($profileId) {
            return array_merge([
                'timetable_slot_id' => $index + 1,
                'profile_id' => $profileId
            ], $log);
        }, $timetableSlots, array_keys($timetableSlots));

        DB::table('timetable_slot')->insert($data);
    }
}
