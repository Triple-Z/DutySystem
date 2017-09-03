<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Employee;
use App\CarRecord;
use App\Record;

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
        $success = true;
        // Last sync time from records table
        $lastSyncTime = Record::latest('created_at')->first()->created_at;
        $this->info('lastSyncTime: ' . $lastSyncTime);
        // Car records waiting to sync to main records table
        $waitToSyncRecords = CarRecord::where('timestamp', '>', $lastSyncTime)->get();

        // For test
        if (isset($waitToSyncRecords)) {
            $this->info('Collection Set');
        } else {
            $this->info('Collection Empty');
        }

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
                    'note' => 'Test sync car records',
                ]);
            } else {
                $this->error('Cannot FIND the employee!');
                $success = false;
            }

        }

        if ($success) {
            $this->info('Car records sync successfully');
        } else {
            $this->error('Sync ERROR');
        }
    }
}
