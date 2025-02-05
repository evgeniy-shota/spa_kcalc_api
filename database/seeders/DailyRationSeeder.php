<?php

namespace Database\Seeders;

use App\Models\DailyRation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailyRationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        for ($i = 0, $size = count($users); $i < $size; $i++) {
            DailyRation::factory()->for($users[$i])->create();
        }
        // DailyRation::factory()->count(20)->create();
    }
}
