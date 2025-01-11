<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\Profile;
use Illuminate\Console\Command;
use App\Models\User;
use GuzzleHttp\Promise\Create;

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

        // $someuser = User::find(2)->profile;
        // $someprofile = Profile::find(3)->user;
        $category = Product::find(43)->category;

        dump($category->toArray());

    
    // Product::factory()->count(50)->create();

    }

}
