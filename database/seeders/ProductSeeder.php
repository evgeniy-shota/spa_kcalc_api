<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = './db_data/products/res';

        if (($fileNames = $this->getFileNames($path)) == false) {
            dd('No such files');
        }



        foreach ($fileNames as $fileName) {

            $categoryName = substr($fileName, 0, strrpos($fileName, '.json'));
            dd($categoryName);
            $categoryId = Category::where('name', $categoryName);
            $products = json_decode(file_get_contents($fileName, 'r'), JSON_UNESCAPED_UNICODE);

            foreach ($products as $product => $value) {

                $prod_calory = 0;
                $prod_prot = 0;
                $prod_carb = 0;
                $prod_fats = 0;
                $prod_nutr = null;

                foreach ($value as $key => $val) {

                    switch ($key) {
                        case "Калорийность":
                            $prod_calory = (int)substr($val, 0, strpos($val, " "));
                            break;
                        case "Белки":
                            $prod_prot = (float)substr($val, 0, strpos($val, " "));
                            break;
                        case "Углеводы":
                            $prod_carb = (float)substr($val, 0, strpos($val, " "));
                            break;
                        case "Жиры":
                            $prod_fats = (float)substr($val, 0, strpos($val, " "));
                            break;
                        case "вещества":
                            $prod_nutr = $val;
                            break;
                    }
                }

                Product::factory()->create([

                    'category_id' => $categoryId,
                    'is_abstract' => $value['is_abstract'],
                    'name' => $product,
                    'manufacturer' => $value['manufacturer'],
                    'quantity_to_calculate' => $value['quantity'],
                    'kcalory' => $prod_calory,
                    'proteins' => $prod_prot,
                    'carbohydrates' => $prod_carb,
                    'fats' => $prod_fats,
                    'kcalory_per_unit' => round($prod_calory / 100, 2),
                    'proteins_per_unit' => round($prod_prot / 100, 2),
                    'carbohydrates_per_unit' => round($prod_carb / 100, 2),
                    'fats_per_unit' => round($prod_fats / 100, 2),
                    'nutrients_and_vitamins' => $prod_nutr,

                ]);
            }
        }
    }

    protected function getFileNames($dirPath)
    {

        if (!is_dir($dirPath)) {
            dump('Is not a directory: ' . $dirPath);
            return false;
        }

        if (($dir = opendir($dirPath)) === false) {
            dump('Can`t open file');
            return false;
        }

        $fileNames = [];

        while (($element = readdir($dir)) !== false) {
            if (!is_dir($element) && ($element != '.' && $element != '..')) {
                $fileNames[] = $element;
            }
        }

        closedir($dir);
        return $fileNames;
    }
}
