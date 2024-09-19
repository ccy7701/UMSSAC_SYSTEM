<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;
use App\Models\Profile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'profile_nickname' => $this->faker->name,
            'profile_personal_desc' => $this->faker->paragraph,
            'profile_enrolment_session' => $this->faker->randomElement(['2021/2022', '2022/2023', '2023/2024']),
            'profile_faculty' => 'FKIKK',
            'profile_course' => $this->faker->randomElement(['UH6481001', 'UH6481002', 'UH6481005']),
            'profile_picture_filepath' => '',
        ];
    }
}
