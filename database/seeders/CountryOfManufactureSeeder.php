<?php

namespace Database\Seeders;

use App\Models\CountryOfManufacture;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryOfManufactureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->readCountriesFromJson();
    }

    protected function readCountriesFromJson()
    {
        $filePath = './db_data/';
        $fileName = 'CountryOfManufacture.json';

        $file = file_get_contents($filePath . $fileName);

        $arrayFromJson = json_decode($file, JSON_UNESCAPED_UNICODE);

        for ($i = 0, $size = count($arrayFromJson); $i < $size; $i++) {
            CountryOfManufacture::factory()->create([
                'name_ru' => $arrayFromJson[$i]['country_ru'],
                'name_en' => $arrayFromJson[$i]['country_en'],
            ]);
        }
    }
}
