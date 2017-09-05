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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // Sync card records to records hourly
        $schedule->command('sync:card')
                    ->hourly()
                    ->timezone('Asia/Shanghai')
                    ->withoutOverlapping()
                    ->evenInMaintenanceMode();

        // Sync car records to records hourly
        $schedule->command('sync:car')
                    ->timezone('Asia/Shanghai')
                    ->hourly()
                    ->withoutOverlapping()
                    ->evenInMaintenanceMode();

        // Simulate check for absence-valid employees
        // At am_start & pm_away

        if (Schema::hasTable('time_nodes')) {
            // Has important table
            $amStart = TimeNode::where('name', '=', 'am_start')->first();
            $pmAway = TimeNode::where('name', '=', 'pm_away')->first();

            if ($amStart && $pmAway) {
                // Create "Hour:minute" strings
                $am_start_hm = $amStart->hour . ':' . $amStart->minute;
                $pm_away_hm = $pmAway->hour . ':' . $pmAway->minute;

                $schedule->command('absence:check')
                            ->timezone('Asia/Shanghai')
                            ->dailyAt($am_start_hm)
                            ->dailyAt($pm_away_hm)
                            ->withoutOverlapping();
            }
    
    
            // Update daily check status daily at pm_end
            
            $pmEnd = TimeNode::where('name', '=', 'pm_end')->first();

            if ($pmEnd) {
                $pm_end_hm = $pmEnd->hour . ':' . $pmEnd->minute;
        
                $schedule->command('daily:status')
                            ->timezone('Asia/Shanghai')
                            ->dailyAt($pm_end_hm)
                            ->withoutOverlapping();
            }
        }

        
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
