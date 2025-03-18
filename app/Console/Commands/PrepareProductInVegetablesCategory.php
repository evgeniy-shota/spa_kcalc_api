<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareProductInVegetablesCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepare-product-in-vegetables-category';

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

        // dd(preg_match('/([Гг]азиров)|([Кк]вас)/', 'Газированный напиток, кола, с высоким содерж') !== false);

        $filePath = './db_data/products/';
        $fileName = 'Овощи и зелень';
        // $fileName = 'Вода и напитки';
        $fileType  = '.json';

        $file = json_decode(file_get_contents($filePath . $fileName . $fileType), JSON_UNESCAPED_UNICODE);

        $categories = [
            'Картофель' => [],
            'Капуста' => [],
            'Кукуруза' => [],
            'Огурцы' => [],
            'Помидоры' => [],
            'Перцы' => [],
            'Лук' => [],
            'Салат' => [],
            'Морковь' => [],
            'Другие овощи' => [],
            'Зелень' => [],
            'Соусы' => [],
            'unknow-vegetables' => [],
        ];

        // $separaitedProducts = [];
        $regPotatoes = '/([Кк]артофе)/';
        $regCabbage = '/([Кк]апуст)/';
        $regCucumbers = '/([Оо]гур)/';
        $regTomatoes = '/([Пп]омид)/';
        $regTomatoes2 = '/([Тт]омат)/';
        $regPeppers = '/([Пп]ерец)/';
        $regOnions = '/([Лл]ук)/';
        $regSalad = '/([Сс]алат)/';
        $regSauce = '/([Сс]оус)/';
        $regCarrot = '/([Мм]орков)/';
        $regParsley = '/([Пп]етрушка)/';
        $regColocasia = '/([Кк]олоказ)/';
        $regCorn = '/([Кк]укуру)/';
        $regJute ='/([Дд]жут)/';
        $regMaranta ='/([Мм]арант)/';
        $regChicory ='/([Цц]икор)/';
        $regSagebrush ='/([Пп]олын)/';
        $regSpinach = '/([Шш]пинат)/';
        $regSorrel = '/([Щщ]авел)/';
        $regVegetables = '/([Тт]ыкв)||([Рр]едис)||([Бб]атат)||([Сс]парж)/';
        $regGreens = '/([Лл]ист)/';


        foreach ($file as $product => $value) {
            // dd($value);
            // strpos($product, 'Энергет') !== false || strpos($product, 'энергет') !== false

            if (preg_match($regSauce, $product) === 1) {
                $categories['Соусы'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regPotatoes, $product) === 1) {
                $categories['Картофель'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regCabbage, $product) === 1) {
                $categories['Капуста'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regCucumbers, $product) === 1) {
                $categories['Огурцы'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regTomatoes, $product) === 1) {
                $categories['Помидоры'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regTomatoes2, $product) === 1) {
                $categories['Помидоры'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regPeppers, $product) === 1) {
                $categories['Перцы'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regOnions, $product) === 1) {
                $categories['Лук'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regSalad, $product) === 1) {
                $categories['Салат'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regCarrot, $product) === 1) {
                $categories['Морковь'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regJute, $product) === 1) {
                $categories['Зелень'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regMaranta, $product) === 1) {
                $categories['Зелень'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regChicory, $product) === 1) {
                $categories['Зелень'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regSagebrush, $product) === 1) {
                $categories['Зелень'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regParsley, $product) === 1) {
                $categories['Зелень'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regColocasia, $product) === 1) {
                $categories['Зелень'][$product] = ($value[0]);
                continue;
            }
            
            if (preg_match($regSpinach, $product) === 1) {
                $categories['Зелень'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regSorrel, $product) === 1) {
                $categories['Зелень'][$product] = ($value[0]);
                continue;
            }
            
            if (preg_match($regGreens, $product) === 1) {
                $categories['Зелень'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regCorn, $product) === 1) {
                $categories['Кукуруза'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regVegetables, $product) === 1) {
                $categories['Другие овощи'][$product] = ($value[0]);
                continue;
            }


            // (strpos($product, 'Негазиров') === false && strpos($product, 'негазиров') === false) &&
            // (strpos($product, 'Газиров') !== false || strpos($product, 'газиров') !== false || strpos($product, 'газиров') !== false || strpos($product, 'газиров') !== false)


            $categories['unknow-vegetables'][$product] = ($value[0]);
        }

        foreach ($categories as $category => $products) {
            dump($category);
            $file = fopen($filePath . 'res/' . $category . '.json', 'w') or die('can`t open file');
            fwrite($file, json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            fclose($file);
        }


        // dd($categories['Сиропы и топпинги']);
    }
}
