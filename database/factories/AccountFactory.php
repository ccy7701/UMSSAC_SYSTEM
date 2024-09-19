<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;

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
        return [
            'account_full_name' => $this->faker->name,
            'account_email_address' => $this->faker->unique()->safeEmail,
            'account_password' => bcrypt('password'),
            'account_role' => 1,
            'account_matric_number' => $this->faker->unique()->numerify('BX########'),
        ];
    }
}
