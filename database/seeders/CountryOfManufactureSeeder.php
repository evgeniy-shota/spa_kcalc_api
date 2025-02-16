<?php

namespace Database\Seeders;

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
        $file = file_get_contents('../../db_data/CountryOfManufacture.json');
        dd($file);
    }
}
