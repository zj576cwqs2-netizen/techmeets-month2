<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'number_of_people' => fake()->numberBetween(1, 5),
            'reserved_at' => fake()->dateTimeBetween('now', '+1 month'),
        ];
    }
}