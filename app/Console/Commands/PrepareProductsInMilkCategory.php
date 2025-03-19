<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareProductsInMilkCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepare-products-in-milk-category';

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
        $fileName = 'Молочные продукты';
        $fileType  = '.json';
        $file = json_decode(file_get_contents($filePath . $fileName . $fileType), JSON_UNESCAPED_UNICODE);

        $categories = [
            'Творожные продукты' => ['/[Сс]ырник/', '/[Пп]удинг/'],
            'Йогурт' => ['/[Йй]огурт/'],
            'Продукты с заменителем молока' => ['/[Зз]аменител/'],
            'Сливки' => ['/[Сс]ливки/'],
            'Масло, маргарин' => ['/[Мм]асло/','/[Мм]аргарин/'],
            'Мороженое' => ['/[Мм]орожен/'],
            'Сметана' => ['/[Сс]метана/'],
            'Творог' => ['/[Тт]ворог/'],
            'Сыр плавленый' => ['/[Пп]лавлен/'],
            'Сыры' => ['/[Сс]ыр/', '/[Сс]улугуни/'],
            'Кефир, кисломолочные продукты' => ['/[Кк]ефир/', '/[Пп]ростокваша/', '/[Рр]яженк/', '/[Сс]ыворотк/','/[Аа]цидофилин/'],
            'Молоко сгущенное' => ['/[Сс]гущенн/'],
            'Молочные напитки' => ['/[Нн]апиток/','/[Кк]коктел/'],
            'Молоко' => ['/[Мм]олоко/'],
            'Другие молочные продукты' => ['/.*/'],
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
