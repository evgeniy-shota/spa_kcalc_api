<?php

namespace Database\Seeders;

use App\Models\DailyRation;
use App\Models\DailyRationProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailyRationProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyRationProduct::factory()->count(count(DailyRation::all()) * 2)->create();
    }
}
