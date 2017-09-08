<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Schema;

use App\CardRecord;
use Carbon\Carbon;
use App\TimeNode;

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
        \App\Console\Commands\TestCommand::class,
        \App\Console\Commands\ListConfig::class,
        \App\Console\Commands\ListCache::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Scheduler logs on `storage/logs/schedule.log`
        $outputFile = storage_path('logs/schedule.log');

        // Sync card records to records hourly
        $schedule->command('sync:card')
                    ->hourly()
                    ->timezone('Asia/Shanghai')
                    ->withoutOverlapping()
                    ->evenInMaintenanceMode()
                    ->appendOutputTo($outputFile);

        // Sync car records to records hourly
        $schedule->command('sync:car')
                    ->timezone('Asia/Shanghai')
                    ->hourly()
                    ->withoutOverlapping()
                    ->evenInMaintenanceMode()
                    ->appendOutputTo($outputFile);

        // Simulate check for absence-valid employees
        // At am_start & pm_away

        if (Schema::hasTable('time_nodes')) {
            // Has important table

            $amStart = TimeNode::where('name', '=', 'am_start')->first();
            $pmAway = TimeNode::where('name', '=', 'pm_away')->first();

            if ($amStart && $pmAway) {
                // Create "Hour:minute" strings
                $amStartTime = Carbon::create(null, null, null, $amStart->hour, $amStart->minute, $amStart->second);
                $pmAwayTime = Carbon::create(null, null, null, $pmAway->hour, $pmAway->minute, $pmAway->second);

                $am_start_hm = $amStartTime->addMinute()->format('h:i');
                $pm_away_hm = $pmAwayTime->addMinute()->format('h:i');

                $schedule->command('absence:check')
                            ->timezone('Asia/Shanghai')
                            ->dailyAt($am_start_hm)
                            ->withoutOverlapping()
                            ->appendOutputTo($outputFile);

                $schedule->command('absence:check')
                            ->timezone('Asia/Shanghai')
                            ->dailyAt($pm_away_hm)
                            ->withoutOverlapping()
                            ->appendOutputTo($outputFile);
            }
    
    
            // Update daily check status daily at pm_end
            
            $pmEnd = TimeNode::where('name', '=', 'pm_end')->first();

            if ($pmEnd) {
                $pmEndTime = Carbon::create(null, null, null, $pmEnd->hour, $pmEnd->minute, $pmEnd->second);
                $pm_end_hm = $pmEndTime->addMinute()->format('h:i');
        
                $schedule->command('daily:status')
                            ->timezone('Asia/Shanghai')
                            ->dailyAt($pm_end_hm)
                            ->withoutOverlapping()
                            ->appendOutputTo($outputFile);
            }
        }

        // Test scheduler command
        // $schedule->command('test:scheduler')
        //             ->timezone('Asia/Shanghai')
        //             ->everyMinute()
        //             ->appendOutputTo($outputFile);

        
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
