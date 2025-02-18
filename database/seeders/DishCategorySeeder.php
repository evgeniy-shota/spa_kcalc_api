<?php

namespace Database\Seeders;

use App\Models\DishCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DishCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DishCategory::factory()->create([
            'user_id' => null,
            'name' => '',
            'is_enabled' => true,
        ]);
    }
}
