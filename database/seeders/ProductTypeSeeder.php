<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = './db_data/products/';
        $fileName = 'productType.json';
        $productTypeFile = json_decode(file_get_contents($path . $fileName), true, JSON_UNESCAPED_UNICODE);

        foreach ($productTypeFile as $productType) {
            $description = strlen($productType['description']) > 0 ? $productType['description'] : null;
            dump($productType['name']);

            ProductType::factory()->create([
                'name' => $productType['name'],
                'description' => $description,
            ]);
        }
    }
}
