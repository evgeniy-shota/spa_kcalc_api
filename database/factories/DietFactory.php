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
                return json_encode(['key1' => 'val1', 'key2' => 'val2', 'key3' => 'val3']);
            }),
            'summ_val' => (function () {
                return json_encode(['key1' => 'val1', 'key2' => 'val2', 'key3' => 'val3']);
            }),
        ];
    }
}
