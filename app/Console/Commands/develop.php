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
        $file = file_get_contents('./db_data/CountryOfManufacture.json');

        // dd(json_decode(json_encode($file)));
        // $pattern = '/\"[\w]*\":\s?\"[\wА-я\s\',().-]*\"/m';
        // $pattern = '/(\[\s{\s)|(,\s},\s{\s)|(\s},\s])/';
        $pattern = '/(\[\s*{\s*)|(,?\s*},\s*{\s*)|(,?\s*},?\s*]?)/';
        $arrayOfCountry = preg_split($pattern, $file);
        $res = [];

        for ($i = 0, $size = count($arrayOfCountry); $i < $size; $i++) {
            $res[] = strpos($arrayOfCountry[$i], ',\n') ?  preg_split('/,\n\s*/', $arrayOfCountry[$i]) : $arrayOfCountry[$i];
        }

        dd($res);

        // $someuser = User::find(2)->profile;
        // $someprofile = Profile::find(3)->user;


        // Product::factory()->count(50)->create();

    }
}
