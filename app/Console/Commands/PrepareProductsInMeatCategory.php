<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareProductsInMeatCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepare-products-in-meat-category';

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
        $fileName = 'Свинина';
        $fileType  = '.json';
        $file = json_decode(file_get_contents($filePath . $fileName . $fileType), JSON_UNESCAPED_UNICODE);

        $categories = [
            'Субпродукты свиные' => ['/([Щщ]ек[ои])/', '/([Мм]озг)/', '/([Жж]елудо)/', '/([Лл]ёгк)/', '/([Лл]егк)/', '/([Сс]елезен)/', '/([Кк]ровь)/', '/([Пп]очк)/', '/([Сс]ердц)/', '/([Кк]ишк)/', '/([Уу]ши)/', '/([Хх]вост)/', '/([Яя]зык)/', '/([Пп]ечен)/', '/([Нн]оги)/'],
            'Ветчина' => ['/([Вв]етчин)/'],
            'Копчености из свинины' => ['/([Бб]екон)/'],
            'Фарш свиной' => ['/([Фф]арш)/'],
            'Свинина' => ['/([Сс]винин)/', '/([Пп]орос[ёея])/'],
            'Другая продукция из свинины' => ['/.*/'],
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
