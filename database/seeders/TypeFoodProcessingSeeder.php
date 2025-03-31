<?php

namespace Database\Seeders;

use App\Enums\TypeOfFoodProcessing;
use App\Models\TypeFoodProcessing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeFoodProcessingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayTypeOfFoodProcessing = TypeOfFoodProcessing::list();
        for ($i = 0, $size = count($arrayTypeOfFoodProcessing); $i < $size; $i++) {
            TypeFoodProcessing::factory()->create([
                'name_ru' => $arrayTypeOfFoodProcessing[$i]->value,
                'name_en' => $arrayTypeOfFoodProcessing[$i]->name,
            ]);
        }
    }
}
