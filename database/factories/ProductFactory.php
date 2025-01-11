<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        // 'category_id'=>fake(),
        'name'=>fake()->name(),
        'product_composition'=> (function(){return json_encode(['key'=>'value', 'key2'=>'value2']);}),
        'description' => fake()->text(),
        'calory'=>fake()->randomDigitNotZero(),
        'proteins'=>fake()->randomDigitNotZero(),
        'carbohydrates'=>fake()->randomDigitNotZero(),
        'fats'=>fake()->randomDigitNotZero(),
        'nutrients_and_vitamins'=> (function(){return json_encode(['key'=>'value', 'key2'=>'value2']);}),
        'is_visible'=>fake()->boolean(),
        ];
    }
}
