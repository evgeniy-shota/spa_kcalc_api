<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class addNewUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-new-user {count=1} {userName=user} {userPass?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new user\users. Signature: count=1 userName=user userPass?';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emailPostfix = '@mail.ru';
        $name = $this->argument('userName');

        while (strlen($name) < 3 || ((int)$this->argument('count') === 1 && count(User::where('name', $name)->get()) !== 0)) {
            $this->warn('user name is too short (min len 3 symbols) or already taken');
            $name = $this->ask('Enter user name (q for quit): ');

            if ($name === 'q') {
                $this->info('Exit command');
                return;
            }
        }

        $password = $this->argument('userPass');

        while (isset($password) && strlen($password) < 8) {
            $this->warn('user password is to short, min len 8 symbols');
            $password = $this->ask('Enter the user password or leave the value blank, then the password will be set from the user name (q for quit): ');

            if ($password === 'q') {
                $this->info('Exit command');
                return;
            }
        }


        if ($this->argument('count') <= 1) {
            $password = isset($password) ? $password  : (strlen($name) >= 4 ? $name . $name : $name . $name . $name);

            User::create([
                'name' => $name,
                'email' => $name . $emailPostfix,
                'password' => Hash::make($password),
            ]);
            $this->info("New user -> $name, password -> $password");
        } else {
            //add random symbols to name if argument count !== 1
            $name .= bin2hex(random_bytes(2));

            for ($i = 0; $i < $this->argument('count'); $i++) {
                $tempName = $name . $i;
                $tempPassword = isset($password) ? $password : (strlen($tempName) >= 4 ? $tempName . $tempName : $tempName . $tempName . $tempName);

                User::create([
                    'name' => $tempName,
                    'email' => $tempName . $emailPostfix,
                    'password' => Hash::make($tempPassword),
                ]);

                $this->info("New user -> $tempName, password -> $tempPassword");
            }
        }

        $this->info('Done!');
    }
}
