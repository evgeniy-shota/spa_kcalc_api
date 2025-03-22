<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class addDailyRationForUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-daily-ration-for-user {userName} {caloryMinLimit?} {caloryMaxLimit?} {fromDate?} {toDate?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add daily rations for user. Sign.: userName caloryLimits* fromDate? toDate?';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $defaultMinCaloryLimit = 2000;
        $defaultMaxCaloryLimit = 3000;

        $fromDate = $this->argument('fromDate') !== null ? $this->argument('fromDate') : date_create('now');

        $toDate = $this->argument('toDate') !== null ? $this->argument('toDate') : date_create('now');

        $minCaloryLimit = $this->argument('caloryMinLimit') !== null ? $this->argument('caloryMinLimit') : $defaultMinCaloryLimit;
        $maxCaloryLimit = $this->argument('caloryMaxLimit') !== null ? $this->argument('caloryMaxLimit') : $defaultMaxCaloryLimit;
    }
}
