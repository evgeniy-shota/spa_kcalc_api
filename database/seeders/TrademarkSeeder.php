<?php

namespace Database\Seeders;

use App\Models\Trademark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrademarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trademark::factory()->count(15)->create();
    }
}
