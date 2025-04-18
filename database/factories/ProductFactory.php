<?php

namespace Database\Factories;

use App\Models\Category;
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
        $quantity_to_calculate = fake()->randomElement([45, 50, 60, 100]);
        $kcalory = fake()->numberBetween(0, 500);
        $proteins = fake()->numberBetween(0, 25);
        $carbohydrates = fake()->numberBetween(0, 70);
        $fats = fake()->numberBetween(0, 30);
        $condition = fake()->randomElement(['liquid', 'solid']);
        $categories = Category::all()->toArray();

        $nutrVit = function () {
            $nutrCount = fake()->numberBetween(3, 10);
            $nutr = [];
            for ($i = 0; $i < $nutrCount; $i++) {
                $nutr[] = [
                    fake()->word() => fake()->randomFloat(2, 0.01, 2.0) . fake()->randomElement(['мкг', 'мг', 'г'])
                ];
            }
            return json_encode($nutr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        };

        return [
            // 'category_id'=>fake(),
            'is_abstract' => true,
            'composition' => fake()->text(),
            'quantity' => fake()->randomElement([100, 200, 500, 1000]),
            'condition' => $condition,
            'units' => $condition == 'solid' ? 'gr' : 'ml',
            'name' => fake()->text(25),
            'description' => fake()->text(100),
            'category_id' => fake()->randomElement($categories)['id'],
            // 'manufacturer' => fake()->randomElement(['ООО', 'ЗАО', 'ОАО', 'ИП']) . fake()->company(),
            'manufacturer_id' => null,
            'quantity_to_calculate' => $quantity_to_calculate,
            'kcalory' => $kcalory,
            'proteins' => $proteins,
            'carbohydrates' => $carbohydrates,
            'fats' => $fats,
            'kcalory_per_unit' => round($kcalory / $quantity_to_calculate, 2),
            'proteins_per_unit' => round($proteins / $quantity_to_calculate, 2),
            'carbohydrates_per_unit' => round($carbohydrates / $quantity_to_calculate, 2),
            'fats_per_unit' => round($fats / $quantity_to_calculate, 2),

            'nutrients_and_vitamins' => $nutrVit

        ];
    }
}
