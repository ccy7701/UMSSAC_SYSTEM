<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('account')->insert([
            [
                'account_id' => 1,
                'account_full_name' => 'Chiew Cheng Yi',
                'account_email_address' => 'chiewccy2@gmail.com',
                'account_password' => '$2y$12$UdMUCW1k18O525T2CpFc8O8hJKZKdKwOLfxmAzkpx2MR2SODYb9Ka',
                'account_role' => 1,
                'account_matric_number' => 'BI21110236',
            ],
            [
                'account_id' => 2,
                'account_full_name' => 'Faculty Chiew',
                'account_email_address' => 'faculty@email.com',
                'account_password' => '$2y$12$G/6PPGNan7KL1YNvYagqTO5h/y2cbCeOKhOznDC9d.WAouZ0BtuQy',
                'account_role' => 2,
                'account_matric_number' => null,
            ],
            [
                'account_id' => 3,
                'account_full_name' => 'Admin Chiew',
                'account_email_address' => 'admin@email.com',
                'account_password' => '$2y$12$4Kasaxyl/3X2OlNmjwl2LO0xBdrQz/AUMeSWAEkmNvlL63gAg/SJq',
                'account_role' => 3,
                'account_matric_number' => null,
            ],
        ]);
    }
}
