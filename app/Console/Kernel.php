<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //Commands\RateCron::class,
	\App\Console\Commands\RateCron::class,
	\App\Console\Commands\RateCron2::class,
    	\App\Console\Commands\ExpiryCron::class,
	\App\Console\Commands\RateBuy::class,
	\App\Console\Commands\expiryIncident::class,
	\App\Console\Commands\AutoAssign::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        //$schedule->command('rate:cron')->everyMinutes();
      // $schedule->command('rate:cron')->cron('* * * * *');
      //  $schedule->command('rate:cron2')->cron('*/5 * * * *'); 
	$schedule->command('expiry:cron')->dailyAt('18:30'); // 12:00 Midnight
//	$schedule->command('rate:buy')->dailyAt('04:30'); //10:00 am
//	$schedule->command('rate:buy')->cron('* * * * *'); //10:00 am
	$schedule->command('expiryIncident:cron')->dailyAt('09:30'); //03:00 pm
	//$schedule->command('autoAssign:cron')->cron('* * * * *'); //Every Five Minute
	$schedule->command('autoAssign:cron')->everyFiveMinutes(); //Every Five Minute



    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
