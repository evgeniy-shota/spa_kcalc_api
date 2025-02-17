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

        $file = Items::fromFile('/home/evgeniy/ssd/learnPhp/laravel/spa_kcalc_api/db_data/prod_res.json');

        foreach ($file as $category => $data) {

            $new_cat = Category::create([
                'name' => $category,
            ]);
            $this->addProducts($data, $new_cat);
        }
    }

    public function addProducts($products, $new_cat)
    {
        foreach ($products as $product => $data) {

            $product_name = $product;
            $prod_cat_id = $new_cat->id;
            $prod_calory = 0;
            $prod_prot = 0;
            $prod_carb = 0;
            $prod_fats = 0;
            $prod_nutr = null;

            foreach ($data as $key => $val) {

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

            $prod_calory_per_unit = round($prod_calory / 100, 2);
            $prod_prot_per_unit = round($prod_prot / 100, 2);
            $prod_carb_per_unit = round($prod_carb / 100, 2);
            $prod_fats_per_unit = round($prod_fats / 100, 2);

            $productTypeLiquidReg = '/([\s]?(В|в)ода[\s]?)|([\s]?(Н|н)ектар[\s]?)|([\s]?(Н|н)апиток[\s]?)|([\s]?(М|м)орс[\s]?)|([\s]?(С|с)ок[\s?])/';
            

            Product::create([
                'name' => $product_name,
                'category_id' => $prod_cat_id,
                'kcalory' => $prod_calory,
                'proteins' => $prod_prot,
                'carbohydrates' => $prod_carb,
                'fats' => $prod_fats,
                'kcalory_per_unit' => $prod_calory_per_unit,
                'proteins_per_unit' => $prod_prot_per_unit,
                'carbohydrates_per_unit' => $prod_carb_per_unit,
                'fats_per_unit' => $prod_fats_per_unit,
                'nutrients_and_vitamins' => json_encode($prod_nutr, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }
}
