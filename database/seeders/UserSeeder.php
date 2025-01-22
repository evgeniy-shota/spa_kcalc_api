<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userName = 'user';
        for ($i = 0; $i < 10; $i++) {
            $iInStr = (string)$i;
            User::factory()->create([
                'name' => $userName . $iInStr,
                'email' => $userName . $iInStr . '@mail.com',
                'password' => $userName . $iInStr,
            ]);
        }
    }
}
