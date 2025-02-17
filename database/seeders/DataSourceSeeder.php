<?php

namespace Database\Seeders;

use App\Models\DataSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = './db_data/';
        $fileName = 'dataSource.json';

        $dataSource = json_decode(file_get_contents($filePath . $fileName), JSON_UNESCAPED_UNICODE);

        for ($i = 0, $size = count($dataSource); $i < $size; $i++) {

            DataSource::factory()->create([
                'name' => $dataSource[$i]['name'],
                'name_orig' => key_exists('name_orig', $dataSource[$i]) ? $dataSource[$i]['name_orig'] : null,
                'description_ru' => $dataSource[$i]['description_ru'],
                'description_en' => key_exists('description_en', $dataSource[$i]) ? $dataSource[$i]['description_en'] : null,
                'citation' => key_exists('citation', $dataSource[$i]) ? $dataSource[$i]['citation'] : null,
                'thumbnail_image_name' => key_exists('thumbnail_image_name', $dataSource[$i]) ? $dataSource[$i]['thumbnail_image_name'] : null,
            ]);
        }
    }
}
