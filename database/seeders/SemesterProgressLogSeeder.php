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
        $this->insertSeederData(1, [
            ['semester' => 1, 'academic_session' => '2021/2022', 'semester_gpa' => 3.96],
            ['semester' => 2, 'academic_session' => '2021/2022', 'semester_gpa' => 3.92],
            ['semester' => 1, 'academic_session' => '2022/2023', 'semester_gpa' => 3.96],
            ['semester' => 2, 'academic_session' => '2022/2023', 'semester_gpa' => 0.00],
            ['semester' => 1, 'academic_session' => '2023/2024', 'semester_gpa' => 0.00],
            ['semester' => 2, 'academic_session' => '2023/2024', 'semester_gpa' => 0.00],
            ['semester' => 1, 'academic_session' => '2024/2025', 'semester_gpa' => 0.00],
            ['semester' => 2, 'academic_session' => '2024/2025', 'semester_gpa' => 0.00]
        ]);
    }

    // Helper function to insert semester progress log data
    private function insertSeederData(int $profileId, array $semesterProgressLogs): void
    {
        $data = array_map(function ($log, $index) use ($profileId) {
            return array_merge([
                'sem_prog_log_id' => $index + 1, // Assuming `sem_prog_log_id` is auto-incremented for each entry
                'profile_id' => $profileId
            ], $log);
        }, $semesterProgressLogs, array_keys($semesterProgressLogs));

        DB::table('semester_progress_log')->insert($data);
    }
}
