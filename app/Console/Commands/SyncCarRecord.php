<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Schema;
use Illuminate\Console\Command;
use App\Employee;
use App\CarRecord;
use App\Record;
use Carbon\Carbon;

class SyncCarRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:car';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync car records into main records table';

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
        $now = Carbon::now('Asia/Shanghai');
        $this->info($now->toDateTimeString() . ' SyncCarRecord');

        $success = true;
        // Last sync time from records table
        // Condition: if there is no empty/first run
        if (Schema::hasTable('records')) {
            $lastRecord = Record::where('check_method', '=', 'car')
                                ->latest('created_at')
                                ->first();
            
            if ($lastRecord) {
                // Table is not empty
                $lastSyncTime = $lastRecord->created_at;
                $this->info('lastSyncTime: ' . $lastSyncTime);
                // Car records waiting to sync to main records table
                $waitToSyncRecords = CarRecord::where('timestamp', '>', $lastSyncTime)->get();
            } else {
                // Table is empty
                $waitToSyncRecords = CarRecord::all();
                $this->info('System first sync car records task.');
            }
        }

        // For test
        if (isset($waitToSyncRecords)) {
            $this->info('Collection Set');
        } else {
            $this->info('Collection Empty');
        }

        $count = 0;
        foreach ($waitToSyncRecords as $carRecord) {

            // A bug occured when it cannot find the employee
            $employee = $carRecord->employee;
            if (isset($employee)) {
                $employeeId = $employee->id;
                $checkDirection = $carRecord->direction;
                $checkTime = $carRecord->timestamp;
    
                Record::create([
                    'employee_id' => $employeeId,
                    'check_direction' => $checkDirection,   
                    'check_method' => 'car',
                    'check_time' => $checkTime,
                    'note' => '',
                ]);
                $count++;

            } else {
                $this->error('Cannot FIND the employee!');
                $success = false;
            }

        }

        if ($success) {
            $this->info('Sync ' . $count . ' car records');
            $this->info('Car records sync successfully');
        } else {
            $this->error('Sync ERROR');
        }
    }
}
