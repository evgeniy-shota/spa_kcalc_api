<?php

namespace Database\Factories;

use App\Models\DailyRation;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyRationProduct>
 */
class DailyRationProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dailyRations = DailyRation::all();
        $randomDailyRation = fake()->randomElement($dailyRations);
        $products = Product::all();
        $randomProduct = fake()->randomElement($products);
        $randomQuantity = fake()->numberBetween(50, 200);
        return [
            'time_of_use' => fake()->time(),
            'daily_ration_id' => $randomDailyRation->id,
            'product_id' => $randomProduct->id,
            'name' => $randomProduct->name,
            'quantity' => $randomQuantity,
            'kcalory_per_unit' => round($randomProduct->kcalory / $randomProduct->quantity_to_calculate, 1),
            'proteins_per_unit' => round($randomProduct->proteins / $randomProduct->quantity_to_calculate, 1),
            'carbohydrates_per_unit' => round($randomProduct->carbohydrates / $randomProduct->quantity_to_calculate, 1),
            'fats_per_unit' => round($randomProduct->fats / $randomProduct->quantity_to_calculate, 1),
        ];
    }
}
