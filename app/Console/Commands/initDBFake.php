<?php

namespace App\Console\Commands;

use App\Models\Activity;
use Illuminate\Console\Command;

use App\Models\User;
use App\Models\Category;
use App\Models\Diet;
use App\Models\Product;

class initDBFake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-d-b-fake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add in data base fake data';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Category::factory()->has(
        //     Product::factory()->count(10)
        // )->count(5)->create();

        // 
    }
}
