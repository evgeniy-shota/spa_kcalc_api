<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataSource>
 */
class DataSourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(20),
            'name_orinal' => fake()->text(20),
            'description_ru' => fake()->text(150),
            'description_en' => fake()->text(150),
            'citation' => fake()->text(75),
            'thumbnail_image_name' => fake()->file(),
            'is_enabled' => fake()->boolean(),
        ];
    }
}
