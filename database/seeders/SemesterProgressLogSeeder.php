<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterProgressLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('semester_progress_log')->insert([
            [
                'sem_prog_log_id' => 1,
                'profile_id' => 1,
                'semester' => 1,
                'academic_session' => '2021/2022',
                'semester_gpa' => 3.96
            ],
            [
                'sem_prog_log_id' => 2,
                'profile_id' => 1,
                'semester' => 2,
                'academic_session' => '2021/2022',
                'semester_gpa' => 3.92
            ],
            [
                'sem_prog_log_id' => 3,
                'profile_id' => 1,
                'semester' => 1,
                'academic_session' => '2022/2023',
                'semester_gpa' => 3.96
            ],
        ]);
    }
}
