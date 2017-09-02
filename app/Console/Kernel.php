<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\CardRecord;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SyncCardRecord::class,
        \App\Console\Commands\SyncCarRecord::class,
        \App\Console\Commands\AbsenceSimCheck::class,
        \App\Console\Commands\UpdateDailyCheckStatus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sync:card')
                    ->timezone('Asia/Shanghai')
                    ->hourly()
                    ->withoutOverlapping();

        $schedule->command('sync:car')
                    ->timezone('Asia/Shanghai')
                    ->hourly()
                    ->withoutOverlapping();

        
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
