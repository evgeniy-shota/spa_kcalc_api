<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalUserProduct>
 */
class PersonalUserProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'personal_user_category_id' => fake()->numberBetween(1, 3),
            'name' => fake()->text(20),
            'product_composition' => json_encode(fn() => [
                fake()->text(10) => fake()->numberBetween(1, 10),
                fake()->text(10) => fake()->numberBetween(1, 10),
                fake()->text(10) => fake()->numberBetween(1, 10),
                fake()->text(10) => fake()->numberBetween(1, 10),
            ]),
            'description' => fake()->text(35),
            'calory' => fake()->numberBetween(0, 500),
            'protein' => fake()->numberBetween(0, 35),
            'carbohydrates' => fake()->numberBetween(0, 70),
            'fat' => fake()->numberBetween(0, 45),
            'nutrients_and_vitamins' => json_encode(fn() => [
                fake()->text(10) => fake()->numberBetween(1, 10),
                fake()->text(10) => fake()->numberBetween(1, 10),
                fake()->text(10) => fake()->numberBetween(1, 10),
                fake()->text(10) => fake()->numberBetween(1, 10),
            ]),
        ];
    }
}
