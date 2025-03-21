<?php

namespace App\Console\Commands;

use App\Models\Profile;
use Illuminate\Console\Command;

class clearProfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-profile 
    {userId? : unique user ID, if not passed, the command is executed for all users }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('userId');

        $defaultProfileValue = [
            'gender' => 'unknow',
            'date_of_birth' => null,
            'height' => null,
            'level_of_training' => 'unknow',
            'level_of_daily_activity' => 'unknow',
            'weight' => null,
            'target_weight' => null,
            'target_energy_value_ration' => null,
        ];

        if ($userId) {
            $profile = Profile::where('user_id', $userId)->update($defaultProfileValue);
            // $profile->gender = 'unknow';
            // $profile->date_of_birth = null;
            // $profile->height = null;
            // $profile->level_of_training = 'unknow';
            // $profile->level_of_daily_activity = 'unknow';
            // $profile->weight = null;
            // $profile->target_weight = null;
            // $profile->target_energy_value_ration = null;
            // $profile->save();
        } else {
            $profiles = Profile::where('id', '<>', null)->update($defaultProfileValue);
        }
    }
}
