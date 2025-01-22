<?php

namespace Database\Seeders;

use App\Models\PersonalUserProduct;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalUserProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        for ($i = 0, $size = count($users); $i < $size; $i++) {

            $personalUserCategories = $users[$i]->personalCategories;

            for ($j = 0, $sizej = count($personalUserCategories); $j < $sizej; $j++) {
                PersonalUserProduct::factory()->count(5)->for($users[$i])->create(['personal_user_category_id' => $personalUserCategories[$j]->id]);
            }
        }
    }
}
