<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $account_role = $this->faker->randomElement([1, 2]);

        return [
            'account_full_name' => $this->faker->name,
            'account_email_address' => $this->faker->unique()->safeEmail,
            'account_password' => bcrypt('password'),
            'account_contact_number' => $this->faker->numerify('01########'),
            'account_role' => $account_role,
            'account_matric_number' => $account_role == 1 ? $this->faker->unique()->numerify('BI########') : null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
