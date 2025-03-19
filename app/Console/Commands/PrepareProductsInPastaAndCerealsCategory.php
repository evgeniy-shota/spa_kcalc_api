<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareProductsInPastaAndCerealsCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepare-products-in-pasta-and-cereals-category';

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
        $fileName = 'Крупы, мука, макароны';
        $fileType  = '.json';
        $file = json_decode(file_get_contents($filePath . $fileName . $fileType), JSON_UNESCAPED_UNICODE);

        $categories = [
            'Мука' => ['/([Мм]ука)/'],
            'Макароны' => ['/([Мм]акарон)/', '/([Пп]аста)/', '/([Pp]asta)/', '/([Сс]пагетти)/'],
            'Хлопья, сухие завтраки' => ['/([Зз]автрак)/', '/([Уу]потреблен)/', '/([Хх]лопья)/'],
            'Рис' => ['/([Рр]ис)/'],
            'Гречка' => ['/([Гг]реч)/'],
            'Пшено' => ['/([Пп]шен)/'],
            'Овсянка' => ['/([Оо]всян)/'],
            'Кукуруза' => ['/([Кк]укуруз)/'],
            'Лапша' => ['/([Лл]апша)/'],
            'Другие крупы' => ['/.*/'],
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
