<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareProductsInNutsCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepare-products-in-nuts-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $filePath = './db_data/products/';
        $fileName = 'Орехи и семена';
        $fileType  = '.json';
        $file = json_decode(file_get_contents($filePath . $fileName . $fileType), JSON_UNESCAPED_UNICODE);

        $categories = [
            'Паста-орехи' => ['/([Пп]аста)/'],
            'Мука-орехи' => ['/([Мм]ука)/'],
            'Молоко-орехи' => ['/([Мм]оло)/'],
            'Кедровый орех' => ['/([Кк]едр)/'],
            'Грецкий орех' => ['/([Гг]рецк)/'],
            'Миндаль' => ['/([Мм]индаль)/'],
            'Пекан' => ['/([Пп]екан)/'],
            'Макадамия' => ['/([Мм]акадами)/'],
            'Фисташки' => ['/([Фф]исташки)/'],
            'Кешью' => ['/([Кк]ешью)/'],
            'Каштан' => ['/([Кк]аштан)/'],
            'Смеси' => ['/([Сс]мес)/'],
            'Семечки' => ['/([Сс]емеч)/', '/([Сс]емя)/', '/([Сс]емена)/'],
            'Другие орехи и семена' => ['/.*/'],
        ];

        $productsRes = [];

        foreach ($file as $product => $value) {

            foreach ($categories as $category => $categotyRegs) {
                $categoryFinded = false;
                for ($i = 0, $size = count($categotyRegs); $i < $size; $i++) {
                    if (preg_match($categotyRegs[$i], $product) === 1) {
                        $productsRes[$category][$product] = $value[0];
                        $categoryFinded = true;
                        break;
                    }
                }
                if ($categoryFinded) {
                    break;
                }
            }
        }

        foreach ($productsRes as $category => $products) {
            dump($category);
            $file = fopen($filePath . 'res/' . $category . '.json', 'w') or die('can`t open file');
            fwrite($file, json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            fclose($file);
        }
    }
}
