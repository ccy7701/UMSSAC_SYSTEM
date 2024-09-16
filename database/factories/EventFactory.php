<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Club;
use App\Models\Event;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'club_id' => Club::factory(),
            'event_name' => $this->faker->text(20),
            'event_location' => $this->faker->streetAddress,
            'event_datetime' => Carbon::now(),
            'event_description' => $this->faker->paragraph,
            'event_entrance_fee' => $this->faker->randomFloat(null, 0.00, 30.00),
            'event_sdp_provided' => $this->faker->randomElement([0, 1]),
            'event_image_paths' => json_encode([]),
            'event_registration_link' => $this->faker->url,
            'event_status' => $this->faker->randomElement([0, 1]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
