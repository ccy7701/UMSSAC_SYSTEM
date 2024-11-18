<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notification;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'profile_id' => 1,
            'notification_type' => $this->faker->randomElement(['studypartner', 'event', 'club']),
            'notification_title' => $this->faker->text(30),
            'notification_message' => $this->faker->text(100),
            'is_read' => 0,
        ];
    }
}
