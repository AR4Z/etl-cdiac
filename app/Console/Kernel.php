<?php

namespace App\Console;

use App\Console\Commands\EtlCommand;
use App\Console\Commands\MigrateInPath;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;
use App\Jobs\EtlYesterdayJob;
use App\Etl\Traits\BaseExecuteEtl;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        EtlCommand::class,
        MigrateInPath::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       //$schedule->command('Etl:Start')->dailyAt('01:00');
       // $schedule->job(new EtlYesterdayJob)->everyMinute();
        /*
        $schedule->call(function(){
            $this->executeAllOriginalYesterday();
        })->everyMinute();*/
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}

