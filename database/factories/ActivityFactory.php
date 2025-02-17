<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'activity_category_id' => fake()->randomElement([0, 1, 2, 3, 4, 5]),
            'name' => fake()->text(10),
            'description' => fake()->text(40),
            'type_of_load' => fake()->randomElement(['duration', 'quantity']),
            'duration_sec_to_calculate' => fake()->randomElement([60, 3600]),
            'quantity_to_calculate' => fake()->numberBetween(10, 100),
            'energy_cost' => fake()->numberBetween(50, 500),
            'energy_cost_per_unit' => fake()->numberBetween(1, 50),
        ];
    }
}
