<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->insertSeederData(1, 'Chiew Cheng Yi', 'chiewccy2@gmail.com', '$2y$12...', 1, 'BI21110236');
        // ...
        // ...
        // ...
    }

    private function insertSeederData($accountId, $accountFullName, $accountEmailAddress, $accountPassword, $accountRole, $accountMatricNumber): void
    {
        $data = [
            'account_id' => $accountId,
            'account_full_name' => $accountFullName,
            'account_email_address' => $accountEmailAddress,
            'account_password' => $accountPassword,
            'account_role' => $accountRole,
            'account_matric_number' => $accountMatricNumber,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table('account')->insert($data);
    }
}
