<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class AccountProfileMixedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::factory()
            ->count(40)
            ->create()
            ->each(function ($account) {
                Profile::factory()
                    ->create([
                        'account_id' => $account->account_id,
                    ]);
            });
    }
}
