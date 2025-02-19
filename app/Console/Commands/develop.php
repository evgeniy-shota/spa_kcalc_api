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
        // $fileName = 'Вода и напитки';
        $fileType  = '.json';

        $file = json_decode(file_get_contents($filePath . $fileName . $fileType), JSON_UNESCAPED_UNICODE);

        $categories = [
            'Птица' => [],
            'Полуфабрикаты'
        ];

        $dishes = [
            'Птица' => [],
        ];

        // $separaitedProducts = [];
        $regDishes = '//';


        foreach ($file as $product => $value) {
            // dd($value);
            // strpos($product, 'Энергет') !== false || strpos($product, 'энергет') !== false
            if (preg_match($regDishes, $product) === 1) {
                $dishes['Птица'][$product] = ($value[0]);
                continue;
            }

            if (preg_match($regDishes, $product) === 1) {
                $dishes['Полуфабрикаты'][$product] = ($value[0]);
                continue;
            }

            $categories['Другие напитки'][$product] = ($value[0]);
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
