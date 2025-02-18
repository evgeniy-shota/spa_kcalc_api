<?php

namespace Database\Seeders;

use App\Models\Dish;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dish::factory()->create([
            'dish_category_id' => '',
            'user_id' => '',
            'name' => '',
            'quantity_to_calculate' => '',
            'kcalory' => '',
            'proteins' => '',
            'carbohydrates' => '',
            'fats' => '',
            'kcalory_per_unit' => '',
            'proteins_per_unit' => '',
            'carbohydrates_per_unit' => '',
            'fats_per_unit' => '',
            'nutrients_and_vitamins' => '',
        ]);
    }
}
