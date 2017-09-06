<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AbsenceValidRecord;
use App\Record;
use Carbon\Carbon;

class AbsenceSimCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absence:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate check for valid absence employees';

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

        $now = Carbon::now('Asia/Shanghai');
        $year = $now->year;
        $month = $now->month;
        $day = $now->day;

        $this->info($now->toDateTimeString() . ' AbsenceSimCheck');

        // Get the valid absence records collection
        $absenceValidRecords = AbsenceValidRecord::where('year', '=', $year)
                                                    ->where('month', '=', $month)
                                                    ->where('day', '=', $day)
                                                    ->get();
        
        foreach ($absenceValidRecords as $record) {
            $employee = $record->employee;
            if (isset($employee)) {
                $employeeId = $employee->id;
                $absenceType = $record->type;

                Record::create([
                    'employee_id' => $employeeId,
                    'check_method' => $absenceType,// 请假类型
                    'check_time' => Carbon::now('Asia/Shanghai'),
                ]);
            } else {
                $this->error('Cannot FIND employee !');
            }
        }

        if ($success) {
            $this->info('Absence sim check successfully');
        } else {
            $this->error('Sim ERROR');
        }
    }
}
