<?php

namespace Database\Seeders;

use App\Models\CategoryGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = './db_data/';
        $fileName = 'categoryGroups.json';

        $file = file_get_contents($filePath . $fileName);
        $arrayFromJson = json_decode($file, JSON_UNESCAPED_UNICODE);

        for ($i = 0, $size = count($arrayFromJson); $i < $size; $i++) {
            CategoryGroup::factory()->create([
                "name" => $arrayFromJson[$i]["name"],
            ]);
        }
    }
}
