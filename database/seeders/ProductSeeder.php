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
        $path = './db_data/products/res/';

        if (($fileNames = $this->getFileNames($path)) == false) {
            dd('No such files');
        }



        foreach ($fileNames as $fileName) {

            $categoryName = substr($fileName, 0, strrpos($fileName, '.json'));
            dump($categoryName);
            $categoryId = (Category::where('name', $categoryName)->get())[0]->id;
            $productsFile = file_get_contents($path . $categoryName . '.json', 'r') or die('can\'t open file...');
            $products = json_decode($productsFile, true, JSON_UNESCAPED_UNICODE);

            // dump($products);

            foreach ($products as $product => $value) {

                dump('->' . $product);
                // dump($value);

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
                            $prod_nutr = json_encode($val, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                            break;
                    }
                }


                Product::factory()->create([

                    'category_id' => $categoryId,
                    'is_abstract' => key_exists('is_abstract', $value) ? $value['is_abstract'] : true,
                    'name' => $product,
                    // 'trademark_id' => key_exists('trademark', $value) ? $value['trademark'] : null,
                    'manufacturer' => key_exists('manufacturer', $value) ? $value['manufacturer'] : null,
                    'description' => key_exists('description', $value) ? $value['description'] : null,
                    'composition' => key_exists('composition', $value) ? $value['composition'] : null,
                    'quantity_to_calculate' => key_exists('quantity_to_calculate', $value) ? $value['quantity_to_calculate'] : 100,
                    'quantity' => key_exists('quantity', $value) ? $value['quantity'] : null,
                    'condition' => key_exists('condition', $value) ? $value['condition'] : 'solid',
                    'units' =>  key_exists('units', $value) ? $value['units'] : 'gr',
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
