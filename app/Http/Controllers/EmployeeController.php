<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\TimeNode;
use Carbon\Carbon;

class EmployeeController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function show_all() {
        $employees = Employee::all();
        return response()->json($employees);
    }

    public function show_records($work_number) {
        $employee = Employee::where('work_number', '=', $work_number)->first();
        $records = $employee->records()->latest('check_time')->paginate(15);
        
        // AM deadline time
        $am_ddl_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'am_start')
                        ->first();
        $am_ddl = Carbon::create(null, null, null, $am_ddl_timeNode->hour, $am_ddl_timeNode->minute, $am_ddl_timeNode->second);
        if ($am_ddl_timeNode->day) {
            $am_start->addDays($am_ddl_timeNode->day);
        }
        // PM away time
        $pm_away_timeNode = DB::table('time_nodes')
                         ->where('name', '=', 'pm_away')
                         ->first();
        $pm_away = Carbon::create(null, null, null, $pm_away_timeNode->hour, $pm_away_timeNode->minute, $pm_away_timeNode->second);
        if ($pm_away_timeNode->day) {
            $pm_away->addDays($pm_away_timeNode->day);
        }

        foreach ($records as $record) {
            
            $check_time_carbon = Carbon::parse($record->check_time);
            $year = $check_time_carbon->year;
            $month = $check_time_carbon->month;
            $day = $check_time_carbon->day;
            $first = true;

            if (($year == $am_ddl->year) && ($month == $am_ddl->month) && ($day == $am_ddl->day) && !$first) {
                continue;// Continue loop, jump this record.
            } else { // The other day

                $am_ddl = Carbon::create($year, $month, $day, $am_ddl_timeNode->hour, $am_ddl_timeNode->minute, $am_ddl_timeNode->second);
                $pm_away = Carbon::create($year, $month, $day, $pm_away_timeNode->hour, $pm_away_timeNode->minute, $pm_away_timeNode->second);

                $records_intime = $employee->records()
                                            ->where('check_time', '>', $am_ddl)
                                            ->where('check_time', '<', $pm_away)
                                            ->oldest('check_time')
                                            ->get();
                
                $stack = array();

                foreach ($records_intime as $record) {
                    array_push($stack, $record);
                    if (count($stack) == 1) { // Check check_direction whether is OUT
                        if ($record->check_direction == 1) { // NOT OUT
                            array_pop($stack);
                        }
                    }
                }

                // if (end($stack)->check_direction == 0) { // Check check_direction whether is IN
                if (end($stack)) {
                    if (end($stack)->check_direction == 0){
                        array_pop($stack);
                    }
                }

                $result_array = array();
                while (end($stack)) { // Stack is not empty
                    $in = array_pop($stack);
                    $out = array_pop($stack);

                    $in_time = Carbon::parse($in->check_time);
                    $out_time = Carbon::parse($out->check_time);

                    $diff = $out_time->diff($in_time);

                    array_push($result_array, [
                        'in_id' => $in->id,
                        'diff' => $diff,
                    ]);
                }

                $first = false;

            }

        }

        return view('employee', [
            'records' => $records,
            'employee' => $employee,
            'in_out_duration' => $result_array,
        ]);
    }

}
