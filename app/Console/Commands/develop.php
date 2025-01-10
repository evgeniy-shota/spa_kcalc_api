<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

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

        $new_user = User::create([

            'name' =>'TestUser2',
            'email'=>'testuser2@mail.com',
            'password'=>'1234',
        ]);

        dump(User::find(1)->toArray());
        //
    }
}
