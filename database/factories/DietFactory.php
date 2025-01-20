<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diet>
 */
class DietFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake(),
            'name' => fake()->text(20),
            'description' => fake()->text(64),
            'products' => (function () {
                return json_encode([fake()->word(3, true) => fake()->numberBetween(0, 300), fake()->word(3, true) => fake()->numberBetween(0, 300), fake()->word(3, true) => fake()->numberBetween(0, 300)]);
            }),
            'summ_val' => (function () {
                return json_encode(['kcal' => fake()->numberBetween(0, 500), 'prot' => fake()->numberBetween(0, 30), 'carb' => fake()->numberBetween(0, 70), 'fats' => fake()->numberBetween(0, 50)]);
            }),
        ];
    }
}
