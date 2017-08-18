<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AbsenceValidRecord;
use Carbon\Carbon;

class AbsenceValidRecordController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function show_all(Request $request) {
        $records = AbsenceValidRecord::all();

        return response()->json($records);
    }

    // write GET/POST/PUT/DELETE method here

    public funciton add_absence(Request $request) {// PUT
        $start_date = Carbon::parse($request->input('start_date'));
        $end_date = Carbon::parse($request->input('end_date'));

        $employeeId = $request->input('employee_id');
        $type = $request->input('type');
        
        if ($start_date->isSameDay($end_date)) {
            $year = $start_date->year;
            $month = $start_date->month;
            $day = $start_date->day;
            AbsenceValidRecord::create([
                'employee_id' => $employeeId,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'type' => $type,
            ]);
        } else {
            $temp_date = $start_date;
            for (!$temp_date->isSameDay($end_date)) {
                $year = $temp_date->year;
                $month = $temp_date->month;
                $day = $temp_date->day;

                AbsenceValidRecord::create([
                    'employee_id' => $employeeId,
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                    'type' => $type,
                ]);

                $temp_date = $temp_date->addDay();
            }
        }

    }

    public function delete_absence(Request $requset) {// DELETE

    }
}
