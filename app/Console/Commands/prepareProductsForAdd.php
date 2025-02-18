<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use JsonMachine\Items;

class prepareProductsForAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepare-products-for-add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'change and add fields to product';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = './db_data/products/';

        if (($files = $this->getFilesNameInDir($filePath)) === false) {
            dd('No such files...');
        }

        // dd($files);

        foreach ($files as $fileName) {
            if (preg_match('/^\d[\wА-я]+/', $fileName)) {
                dump($fileName);
                continue;
            }

            $newFileName = '0' . $fileName;
            $newFilePath = $filePath;

            $file = Items::fromFile($filePath . $fileName);
            $newArrayProducts = [];

            foreach ($file as $key => $value) {
                // $newFileName = $key . '.json';
                $data = (json_decode(json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

                dump($key);

                if (($subFrom = strpos($key, '[')) && ($subTo = strrpos($key, ']'))) {

                    $manufacturer = substr($key, $subFrom + 1, $subTo - $subFrom - 1);
                    $newKey = trim(substr($key, 0, $subFrom));
                    dump('^-> ' . $newKey);
                } else {
                    $manufacturer = null;
                    $newKey = $key;
                }


                $newArrayProducts[$newKey][] = [
                    // "manufacturer" => preg_split('/(.*\[)|(\].*)/', $key),
                    "manufacturer" => $manufacturer,
                    "is_abstract" => $manufacturer ? false : true,
                    ...$data,
                ];
                // dd($newArrayProducts);
            }


            $newFile = fopen($newFilePath . $newFileName, 'w') or die('can`t open file');
            fwrite($newFile, json_encode($newArrayProducts, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            fclose($newFile);
        }
        dd();
        // $fileName = 'Бондюэль';
        // $fileType = '.json';


        // '/home/evgeniy/ssd/learnPhp/laravel/spa_kcalc_api/db_data/prod_res.json'

        // $arrayFromJson = json_decode($file, JSON_UNESCAPED_UNICODE);
        // $res = [];


        // $someuser = User::find(2)->profile;
        // $someprofile = Profile::find(3)->user;


        // Product::factory()->count(50)->create();

    }

    protected function getFilesNameInDir($path)
    {
        if (!is_dir($path)) {
            dump('Is not dir: ' . $path);
            return false;
        }

        if ($dir = opendir($path)) {
            // dump($dir);
            $filesName = [];
            while (($element = readdir($dir)) !== false) {
                if (!is_dir($element) && ($element != '.' || $element != '..')) {

                    // dump($element);
                    $filesName[] = $element;
                }
            }
            closedir($dir);
            return $filesName;
        }

        dump('Can`t open dir...');
        return false;
    }
}
