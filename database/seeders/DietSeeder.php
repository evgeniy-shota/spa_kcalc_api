<?php

namespace Database\Seeders;

use App\Models\Diet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DietSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = User::all();
        for ($i = 0, $size = count($users); $i < $size; $i++) {
            Diet::factory()->count(10)->for($users[$i])->create();
        }
    }
}
