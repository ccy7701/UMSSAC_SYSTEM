<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectStatsLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subject_stats_log')->insert([
            // S1-2021/2022
            [
                'sem_prog_log_id' => 1,
                'subject_code' => 'EK00703',
                'subject_name' => 'Public Speaking / Elocution',
                'subject_credit_hours' => 3,
                'subject_grade' => 'A',
                'subject_grade_point' => 12.00,
            ],
            [
                'sem_prog_log_id' => 1,
                'subject_code' => 'KT14303',
                'subject_name' => 'Programming Principles',
                'subject_credit_hours' => 3,
                'subject_grade' => 'A',
                'subject_grade_point' => 12.00,
            ],
            [
                'sem_prog_log_id' => 1,
                'subject_code' => 'KT14503',
                'subject_name' => 'Mathematics for Computing',
                'subject_credit_hours' => 3,
                'subject_grade' => 'A',
                'subject_grade_point' => 12.00,
            ],
            [
                'sem_prog_log_id' => 1,
                'subject_code' => 'UD00102',
                'subject_name' => 'Kadazandusun Language Level I',
                'subject_credit_hours' => 2,
                'subject_grade' => 'A',
                'subject_grade_point' => 8.00,
            ],
            [
                'sem_prog_log_id' => 1,
                'subject_code' => 'UL02402',
                'subject_name' => 'Government and People in Southeast Asia',
                'subject_credit_hours' => 2,
                'subject_grade' => 'A-',
                'subject_grade_point' => 7.34,
            ],
            [
                'sem_prog_log_id' => 1,
                'subject_code' => 'UW00702',
                'subject_name' => 'Philosophy and Contemporary Issues',
                'subject_credit_hours' => 2,
                'subject_grade' => 'A',
                'subject_grade_point' => 8.00,
            ],
            // S2-2021/2022
            [
                'sem_prog_log_id' => 2,
                'subject_code' => 'KK14202',
                'subject_name' => 'Software Project Management',
                'subject_credit_hours' => 2,
                'subject_grade' => 'A',
                'subject_grade_point' => 8.00,
            ],
            [
                'sem_prog_log_id' => 2,
                'subject_code' => 'KT14403',
                'subject_name' => 'Discrete Structures',
                'subject_credit_hours' => 3,
                'subject_grade' => 'A',
                'subject_grade_point' => 12.00,
            ],
            [
                'sem_prog_log_id' => 2,
                'subject_code' => 'KT14603',
                'subject_name' => 'Data Structures and Algorithms',
                'subject_credit_hours' => 3,
                'subject_grade' => 'A',
                'subject_grade_point' => 12.00,
            ],
            [
                'sem_prog_log_id' => 2,
                'subject_code' => 'KT14803',
                'subject_name' => 'Network Fundamentals',
                'subject_credit_hours' => 3,
                'subject_grade' => 'A',
                'subject_grade_point' => 12.00,
            ],
            [
                'sem_prog_log_id' => 2,
                'subject_code' => 'UD00202',
                'subject_name' => 'Kadazandusun Language Level II',
                'subject_credit_hours' => 2,
                'subject_grade' => 'A',
                'subject_grade_point' => 8.00,
            ],
            [
                'sem_prog_log_id' => 2,
                'subject_code' => 'UL03202',
                'subject_name' => 'Marine and Community Development',
                'subject_credit_hours' => 2,
                'subject_grade' => 'A-',
                'subject_grade_point' => 7.34,
            ],
            [
                'sem_prog_log_id' => 2,
                'subject_code' => 'UW00802',
                'subject_name' => 'Appreciation of Ethics and Civilisations',
                'subject_credit_hours' => 2,
                'subject_grade' => 'A-',
                'subject_grade_point' => 7.34,
            ],
            // S1-2022/2023
            [
                'sem_prog_log_id' => 3,
                'subject_code' => 'UD00302',
                'subject_name' => 'Kadazandusun Language Level III',
                'subject_credit_hours' => 2,
                'subject_grade' => 'A',
                'subject_grade_point' => 8.00,
            ],
            [
                'sem_prog_log_id' => 3,
                'subject_code' => 'UW00302',
                'subject_name' => 'Fundamentals of Entrepreneurial Acculturation',
                'subject_credit_hours' => 2,
                'subject_grade' => 'A-',
                'subject_grade_point' => 7.34,
            ],
            [
                'sem_prog_log_id' => 3,
                'subject_code' => 'KK24703',
                'subject_name' => 'Object Oriented Programming',
                'subject_credit_hours' => 3,
                'subject_grade' => 'A',
                'subject_grade_point' => 12.00,
            ],
            [
                'sem_prog_log_id' => 3,
                'subject_code' => 'KK24503',
                'subject_name' => 'Requirements Engineering',
                'subject_credit_hours' => 3,
                'subject_grade' => 'A',
                'subject_grade_point' => 12.00,
            ],
            [
                'sem_prog_log_id' => 3,
                'subject_code' => 'KT24703',
                'subject_name' => 'Computer Architecture and Organization',
                'subject_credit_hours' => 3,
                'subject_grade' => 'A',
                'subject_grade_point' => 12.00,
            ],
            [
                'sem_prog_log_id' => 3,
                'subject_code' => 'KT24903',
                'subject_name' => 'Probability and Statistics',
                'subject_credit_hours' => 3,
                'subject_grade' => 'A',
                'subject_grade_point' => 12.00,
            ],
        ]);
    }
}
