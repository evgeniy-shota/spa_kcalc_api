<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;
use \JsonMachine\Items;

class init_db_tables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init_db_tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init Category and Product tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->readData();
    }

    public function readData()
    {
        $index = 0;

        $file = Items::fromFile('/home/evgeniy/ssd/learnPhp/laravel/spa_kcalc_api/db_data/prod_res.json');

        foreach ($file as $category => $data) {
            
            $new_cat = Category::create([
                'name' => $category,
            ]);
            $this->addProducts($data, $new_cat);
            // dump($category);
            // dump($data);
            $index++;
        }

        // dump($categories);
        // $this->addCategories($categories);
    }

    public function addCategories($category)
    {
        
    }

    public function addProducts($products, $new_cat)
    {
        foreach ($products as $product => $data) {

            // $new_product = [];
            // $new_product['name'] = $product;
            // $new_product['category_id'] = $new_cat;

            $product_name = $product;
            $prod_cat_id = $new_cat->id;
            // dd($prod_cat_id);
            $prod_calory = 0;
            $prod_prot = 0;
            $prod_carb = 0;
            $prod_fats = 0;
            $prod_nutr = null;

            foreach ($data as $key => $val) {

                switch ($key) {
                    case "Калорийность":
                        // $new_key = "calory";
                        // $new_val = (int)substr($val, 0, strpos($val, " "));
                        $prod_calory = (int)substr($val, 0, strpos($val, " "));
                        break;
                    case "Белки":
                        // $new_key = "proteins";
                        // $new_val = (float)substr($val, 0, strpos($val, " "));
                        $prod_prot = (float)substr($val, 0, strpos($val, " "));
                        break;
                    case "Углеводы":
                        // $new_key = "carbohydrates";
                        // $new_val = (float)substr($val, 0, strpos($val, " "));
                        $prod_carb = (float)substr($val, 0, strpos($val, " "));
                        break;
                    case "Жиры":
                        // $new_key = "fats";
                        // $new_val = (float)substr($val, 0, strpos($val, " "));
                        $prod_fats = (float)substr($val, 0, strpos($val, " "));
                        break;
                    case "вещества":
                        // $new_key = "nutrients_and_vitamins";
                        // $new_val = $val;
                        $prod_nutr = $val;
                        break;
                }

                // $new_product[$new_key] = $new_val;
            }

            // sleep(10);

            // dump(...$new_product);

            Product::create([
                'name' => $product_name,
                'category_id' => $prod_cat_id,
                'calory' => $prod_calory,
                'proteins' => $prod_prot,
                'carbohydrates' => $prod_carb,
                'fats' => $prod_fats,
                'nutrients_and_vitamins' => json_encode($prod_nutr),
            ]);

            // dump($new_product);
            // sleep(10);

            // $name = $product;
            // $calory = ((array)$data)["Калорийность"];
            // $protein = ((array)$data)["Белки"];
            // $carb = ((array)$data)["Углеводы"];
            // $fats = ((array)$data)["Жиры"];
            // $nutrients = ((array)$data)["вещества"];
        }
    }
}
