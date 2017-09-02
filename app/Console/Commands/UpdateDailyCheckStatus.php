<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Employee;
use App\TimeNode;
use App\DailyCheckStatus;
use Carbon\Carbon;

class UpdateDailyCheckStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update daily check status for all the employees';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $success = true;

        $employees = Employee::orderBy('work_number')
                                ->get();
        
        // Decide whether function should be use.
        // Depends on pm_end whether is the next day.
        // If the next day, then should be update the former day's data.
        $pmEnd = TimeNode::where('name', '=', 'pm_end')->first();
        $pmEndDay = $pmEnd->day;
        $isSameDay = false;
        if ($pmEndDay) { // No zero
            $dateString = Carbon::now('Asia/Shanghai')
                                ->subDays($pmEndDay)
                                ->toDateString();
        } else {
            $dateString = Carbon::now('Asia/Shanghai')
                                ->toDateString();
            $isSameDay = true;
        }

        $this->info('Update date: ' . $dateString);
        

        foreach ($employees as $employee) {

            $employeeId = $employee->id;
            
            if ($isSameDay) {
                // pm_end day is the same day as current date
                $amCheckRecord = $employee->special_records()['today_am_earliest_record'];
                $pmCheckRecord = $employee->special_records()['today_pm_earliest_record'];
                $amAwayRecord = $employee->special_records()['today_am_latest_record'];
                $pmAwayRecord = $employee->special_records()['today_pm_latest_record'];
                $status = $employee->special_records()['check_status'];
            } else {
                
                $amCheckRecord = $employee->special_records_date($dateString)['today_am_earliest_record'];
                $pmCheckRecord = $employee->special_records_date($dateString)['today_pm_earliest_record'];
                $amAwayRecord = $employee->special_records_date($dateString)['today_am_latest_record'];
                $pmAwayRecord = $employee->special_records_date($dateString)['today_pm_latest_record'];
                $status = $employee->special_records_date($dateString)['check_status'];
            }
            
            // Validate string whether is null object!
            if ($amCheckRecord) {
                $amCheck = Carbon::parse($amCheckRecord->check_time);
            } else {
                $amCheck = null;
            }

            if ($pmCheckRecord) {
                $pmCheck = Carbon::parse($pmCheckRecord->check_time);
            } else {
                $pmCheck = null;
            }

            if ($amAwayRecord) {
                $amAway = Carbon::parse($amAwayRecord->check_time);
            } else {
                $amAway = null;
            }

            if ($pmAwayRecord) {
                $pmAway = Carbon::parse($pmAwayRecord->check_time);
            } else {
                $pmAway = null;
            }

            DailyCheckStatus::create([
                'employee_id' => $employeeId,
                'date' => $dateString,
                'am_check' => $amCheck,
                'am_away' => $amAway,
                'pm_check' => $pmCheck,
                'pm_away' => $pmAway,
                'status' => $status,
            ]);

        }

        if ($success) {
            $this->info('Update daily check status table successfully');
        } else {
            $this->error('Update ERROR');
        }
    }
}
