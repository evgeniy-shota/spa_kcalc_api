<?php

namespace Database\Seeders;

use App\Models\Category;
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
        $fileName = '.json';

        $categories = json_decode(file_get_contents($filePath . $fileName));

        for ($i = 0, $size = count($categories); $i < $size; $i++) {
            Category::factory()->create([
                'category_group_id' => $categories[$i]['category_group_id'],
                'name' => $categories[$i]['name'],
            ]);
        }
    }
}
