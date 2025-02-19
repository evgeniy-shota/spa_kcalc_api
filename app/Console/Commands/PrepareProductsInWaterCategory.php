<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrepareProductsInWaterCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepare-products-in-water-category';

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
        $fileName = 'Напитки';
        // $fileName = 'Вода и напитки';
        $fileType  = '.json';

        $file = json_decode(file_get_contents($filePath . $fileName . $fileType), JSON_UNESCAPED_UNICODE);
        
        $categories = [
            'Вода' => [],
            'Газированные напитки, квас' => [],
            'Соки, нектары, морсы' => [],
            'Другие напитки' => [],
            'Энергетические напитки' => [],
            'Чай' => [],
            'Кофе' => [],
            'Сиропы и топпинги' => [],
            'Другие горячие напитки' => []
        ];

        // $separaitedProducts = [];
        $regWater = '/[Вв]ода/';
        $regTea = '/[Чч]ай/';
        $regCoffee = '/[Кк]офе/';
        $regHot = '/[Шш]околад|([Кк]акао)/';
        $regOqsyWater = '/([Гг]азиров)|([Кк]вас)/';
        $regNotOqsyWater = '/[Нн]егазиров/';
        $regEnergy = '/[Ээ]нергети/';
        $regJuice = '/(\s?[Сс]ок\s?)|(\s?[Нн]ектар\s?)|(\s?[Мм]орс\s?)/';
        $regSyrup = '/[Сс]ироп/';


        foreach ($file as $product => $value) {
            // dd($value);
            // strpos($product, 'Энергет') !== false || strpos($product, 'энергет') !== false
            if (preg_match($regEnergy, $product) === 1) {
                $categories['Энергетические напитки'][$product] = ($value[0]);
                continue;
            }

            // (strpos($product, 'Негазиров') === false && strpos($product, 'негазиров') === false) &&
            // (strpos($product, 'Газиров') !== false || strpos($product, 'газиров') !== false || strpos($product, 'газиров') !== false || strpos($product, 'газиров') !== false)

            if (
                preg_match($regNotOqsyWater, $product) === 0 &&
                preg_match($regOqsyWater, $product) === 1
            ) {
                $categories['Газированные напитки, квас'][$product] = ($value[0]);
                // dump($product);
                continue;
            }

            if (preg_match($regJuice, $product) === 1) {
                $categories['Соки, нектары, морсы'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regTea, $product) === 1) {
                $categories['Чай'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regCoffee, $product) === 1) {
                $categories['Кофе'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regSyrup, $product) === 1) {
                $categories['Сиропы и топпинги'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regHot, $product) === 1) {
                $categories['Другие горячие напитки'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regWater, $product) === 1) {
                $categories['Вода'][$product] = ($value[0]);
                continue;
            }

            $categories['Другие напитки'][$product] = ($value[0]);
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
