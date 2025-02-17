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
        $filePath = './db_data/';
        $fileName = 'CountryOfManufacture.json';

        $file = Items::fromFile('/home/evgeniy/ssd/learnPhp/laravel/spa_kcalc_api/db_data/prod_res.json');
        
        // $arrayFromJson = json_decode($file, JSON_UNESCAPED_UNICODE);
        // $res = [];


        // $someuser = User::find(2)->profile;
        // $someprofile = Profile::find(3)->user;


        // Product::factory()->count(50)->create();

    }
}
