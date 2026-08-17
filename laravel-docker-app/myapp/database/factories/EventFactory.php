<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'event_date' => fake()->dateTimeBetween('now', '+1 year'),
            'location' => fake()->city(),
            'capacity' => fake()->numberBetween(10, 100),

        ];
    }
}
