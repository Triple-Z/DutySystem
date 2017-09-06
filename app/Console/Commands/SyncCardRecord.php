<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Schema;
use Illuminate\Console\Command;
use App\Record;
use App\Employee;
use App\CardRecord;
use Carbon\Carbon;


class SyncCardRecord extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:card';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync card records into main records table';

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
        $this->info($now->toDateTimeString() . ' SyncCardRecord');

        $success = true;
        // Last sync time from records table
        // Condition: if there is no empty/first run
        if (Schema::hasTable('records')) {
            $lastRecord = Record::where('check_method', '=', 'card')
                                ->latest('created_at')
                                ->first();
            
            if ($lastRecord) {
                // Table is not empty
                $lastSyncTime = Record::latest('created_at')->first()->created_at;
                $this->info('lastSyncTime: ' . $lastSyncTime);
                // Card records waiting to sync to main records table
                $waitToSyncRecords = CardRecord::where('timestamp', '>', $lastSyncTime)->get();
            } else {
                // Table is empty
                $waitToSyncRecords = CardRecord::all();
                $this->info('System first sync card records task.');
            }
        }

        // For test
        if (isset($waitToSyncRecords)) {
            $this->info('Collection Set');
        } else {
            $this->info('Collection Empty');
        }

        $count = 0;
        foreach ($waitToSyncRecords as $cardRecord) {

            // A bug occured when it cannot find the employee
            $employee = $cardRecord->employee;
            if (isset($employee)) {
                $employeeId = $employee->id;
                $checkDirection = $cardRecord->direction;
                $cardGate = $cardRecord->card_gate;
                $checkTime = $cardRecord->timestamp;
    
                Record::create([
                    'employee_id' => $employeeId,
                    'check_direction' => $checkDirection,   
                    'check_method' => 'card',
                    'check_time' => $checkTime,
                    'card_gate' => $cardGate,
                    'note' => '',
                ]);
                $count++;

            } else {
                $this->error('Cannot FIND the employee!');
                $success = false;
            }

        }

        if ($success) {
            $this->info('Sync ' . $count . ' card records');
            $this->info('Card records sync successfully');
        } else {
            $this->error('Sync ERROR');
        }

    }
}
