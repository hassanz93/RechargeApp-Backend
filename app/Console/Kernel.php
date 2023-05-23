<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel

{

    protected $commands = [

        Commands\ResetLimit::class,

    ];
   
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('resetLimit:cron')->dailyAt('00:00');

    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
