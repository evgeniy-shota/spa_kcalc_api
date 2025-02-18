<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Console\Command;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\Expr\Cast\Object_;
use JsonMachine\Items;

class develop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:develop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run user command';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // dd(preg_match('/([Гг]азиров)|([Кк]вас)/', 'Газированный напиток, кола, с высоким содерж') !== false);

        $filePath = './db_data/products/';
        $fileName = 'Напитки';
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

            // strpos($product, 'Энергет') !== false || strpos($product, 'энергет') !== false
            if (preg_match($regEnergy, $product) === 1) {
                $categories['Энергетические напитки'][$product] = $value;
                continue;
            }

            // (strpos($product, 'Негазиров') === false && strpos($product, 'негазиров') === false) &&
            // (strpos($product, 'Газиров') !== false || strpos($product, 'газиров') !== false || strpos($product, 'газиров') !== false || strpos($product, 'газиров') !== false)

            if (
                preg_match($regNotOqsyWater, $product) === 0 &&
                preg_match($regOqsyWater, $product) === 1
            ) {
                $categories['Газированные напитки, квас'][$product] = $value;
                // dump($product);
                continue;
            }

            if (preg_match($regJuice, $product) === 1) {
                $categories['Соки, нектары, морсы'][$product] = $value;
                continue;
            }

            if (preg_match($regTea, $product) === 1) {
                $categories['Чай'][$product] = $value;
                continue;
            }

            if (preg_match($regCoffee, $product) === 1) {
                $categories['Кофе'][$product] = $value;
                continue;
            }

            if (preg_match($regSyrup, $product) === 1) {
                $categories['Сиропы и топпинги'][$product] = $value;
                continue;
            }

            if (preg_match($regHot, $product) === 1) {
                $categories['Другие горячие напитки'][$product] = $value;
                continue;
            }

            if (preg_match($regWater, $product) === 1) {
                $categories['Вода'][$product] = $value;
                continue;
            }

            $categories['Другие напитки'][$product] = $value;
        }

        foreach ($categories as $category => $products) {
            dump($category);
            $file = fopen($filePath . 'res/' . $category . '.json', 'a') or die('can`t open file');
            fwrite($file, json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            fclose($file);
        }


        // dd($categories['Сиропы и топпинги']);
    }
}
