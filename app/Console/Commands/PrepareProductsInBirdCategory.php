<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareProductsInBirdCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepare-products-in-bird-category';

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
        $fileName = 'Птица';
        $fileType  = '.json';
        $file = json_decode(file_get_contents($filePath . $fileName . $fileType), JSON_UNESCAPED_UNICODE);

        $categories = [
            'Субпродукты птицы' => ['/([Пп]ечен)/', '/([Сс]ерд)/', '/([Пп]отрох)/', '/([Шш]ейк)/', '/([Жж]елуд)/'],
            'Индейка' => ['/([Ии]нде)/', '/([Ии]ндюк)/', '/([Ии]ндюш)/'],
            'Курица' => ['/([Кк]уриц)/', '/([Бб]ройл)/', '/([Кк]урин)/', '/([Цц]ыпл)/'],
            'Утка' => ['/([Уу]тк)/', '/([Уу]тят)/'],
            'Другая птица' => ['/.*/'],
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
