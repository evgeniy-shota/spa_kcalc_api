<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DayliRation>
 */
class DailyRationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::all();
        // $products = Product::all();
        // $product1 = fake()->randomElement($products);
        // $product2 = fake()->randomElement($products);
        // $product3 = fake()->randomElement($products);

        return [
            // 'time_of_use' => fake()->time(),
            'user_id' => fake()->randomElement($users),
            'description' => fake()->text(20),
            // 'products' => ,
            // 'ration_summary' => json_encode([
            //     'kcalory' => fake()->numberBetween(100, 500),
            //     'carbohydrates' => fake()->numberBetween(20, 70),
            //     'proteins' => fake()->numberBetween(6, 25),
            //     'fats' => fake()->numberBetween(0, 50),
            // ]),
        ];
    }
}
