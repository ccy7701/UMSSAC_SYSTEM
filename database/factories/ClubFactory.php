<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Club;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Club>
 */
class ClubFactory extends Factory
{
    protected $model = Club::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'club_name' => $this->faker->company,
            'club_category' => $this->faker->randomElement(['ASTIF', 'FIS', 'FKAL', 'FKIKK', 'FKIKAL', 'FKJ', 'FPEP', 'FPL', 'FPP', 'FPSK']),
            'club_description' => $this->faker->paragraph,
            'club_image_paths' => json_encode([]),
        ];
    }
}
