<?php

namespace Database\Seeders;

use App\Models\PersonalUserCategory;
use App\Models\User;
use Database\Factories\PersonalUserCategoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalUserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        for ($i = 0, $size = count($users); $i < $size; $i++) {
            PersonalUserCategory::factory()->count(3)->for($users[$i])->create();
        }
    }
}
