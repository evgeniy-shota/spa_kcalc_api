<?php

namespace Database\Seeders;

use App\Models\DailyRation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailyRationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DailyRation::factory()->count(20)->create();
    }
}
