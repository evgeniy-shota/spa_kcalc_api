<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = './db_data/';
        $fileName = 'categories.json';

        $categories = json_decode(file_get_contents($filePath . $fileName));

        for ($i = 0, $size = count($categories); $i < $size; $i++) {
            dump($categories[$i]->group);
            // dump((CategoryGroup::where('name', $categories[$i]->group)->first())->id);
            Category::factory()->create([
                'category_group_id' => (CategoryGroup::where('name', $categories[$i]->group)->first())->id,
                'name' => $categories[$i]->name,
                'is_enabled' => property_exists($categories[$i], 'is_enabled') ? $categories[$i]->is_enabled : true,
            ]);
        }
    }
}
