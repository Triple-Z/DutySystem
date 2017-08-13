<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Record;
use Carbon\Carbon;
use App\TimeNode;
use App\HolidayDate;


class RouteController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function valid() {
        $employees = Employee::orderBy('work_number')->paginate(15);
        
        return view('valid', [
            'employees' => $employees,
        ]);
    }

    public function valid_date(Request $request) {
        $date = $request->input('date');

        $employees = Employee::orderBy('work_number')->paginate(15);

        return view('valid_date', [
            'employees' => $employees,
            'date' => $date,
        ]);
    }

    public function graph() {
        return view('graph');
    }

    // public function correct() {
    //     return view('correct');
    // }

    public function report(Request $request) {
        if ($request->input('month')) {
            $date = $request->input('month');
        } else {
            $date = Carbon::now('Asia/Shanghai')->toDateString();
        }
        $now = Carbon::now('Asia/Shanghai');
        $time = Carbon::parse($date);
        
        $employees = Employee::orderBy('work_number')->paginate(15);
        
        $year = $time->year;
        $month = $time->month;
        $holidays = HolidayDate::where('year', '=', $year)
                                ->where('month', '=', $month)
                                ->orderBy('day')
                                ->get();

        if (($now->year == $time->year) && ($now->month == $time->month)) {// Same month
            $holidays_in_month = HolidayDate::where('year', '=', $year)
                                            ->where('month', '=', $month)
                                            ->where('day', '<=', $time->day)
                                            ->get();
            $valid_days = ($time->day) - ($holidays_in_month->count());
        } else { // Former month
            $maxDay = $time->addMonth()->subDay()->day;
            $valid_days = $maxDay - ($holidays->count());
        }

        return view('report', [
            'employees' => $employees,
            'date' => $date,
            'valid_days' => $valid_days,
        ]);
    }

    // public function report_date(Request $request) {
    //     $date = $request->input('date');

    //     return view('report', [
    //         'employees' => $employees,
    //     ])
    // }

    public function holidays(Request $request) {

        // $now = Carbon::now('Asia/Shanghai');
        // $year = $now->year;
        // $month = $now->month;

        // $holidays = HolidayDate::where('year', '=', $year)
        //                         ->where('month', '=', $month)
        //                         ->orderBy('day')
        //                         ->get();
        
        // Return JSON for test
        //return response()->json($holidays);

        return view('holidays');

    }

    public function holidays_content(Request $request) {
        $now = Carbon::now('Asia/Shanghai');
        $year = $now->year;
        $month = $now->month;

        $holidays = HolidayDate::where('year', '=', $year)
                                ->where('month', '=', $month)
                                ->orderBy('day')
                                ->get();
        // Return JSON for test
        // return response()->json(['date'=>'2017-08-04']);

        //return response()->json($holidays);

        
        $holidays_formatted = array();
        
        foreach ($holidays as $holiday) {
            // Format the date
            $temp_time = Carbon::create($holiday->year, $holiday->month, $holiday->day, null, null, null);
// <<<<<<< fix-date-return
            array_push($holidays_formatted, [
            	'date' => $temp_time->toDateString(),
            ]);
        }
        
        return response()->json($holidays_formatted);
        // if it cannot return normal JSON array, use the code following.
        // return json_encode($holidays_formatted);
// =======
//             array_push($holidays_formatted, $temp_time->toDateString());
//         }
        
//         return $holidays_formatted;
// >>>>>>> dev
    }

    public function holidays_search() {
        $date = Carbon::parse($request->input('month'));
        $year = $date->year;
        $month = $date->month;

        $holidays = HolidayDate::where('year', '=', $year)
                                ->where('month', '=', $month)
                                ->orderBy('day')
                                ->get();

        // Return JSON for test
        return response()->json($holidays);

        // return view('holiday', [
        //     'holidays' => $holidays,
        // ]);
    }

    public function holidays_update(Request $request) {
        $date = Carbon::parse($request->input('month'));
        $year = $date->year;
        $month = $date->month;

        $new_holidays = $request->input('days');

        $deleted_holidays = HolidayDate::where('year', '=', $year)
                                        ->where('month', '=', $month)
                                        ->delete();

        foreach ($new_holidays as $holiday) {
            HolidayDate::create([
                'year' => year,
                'month' => month,
                'day' => $holiday,
            ]);
        }

        $request->session()->flash('flash_success', '节假日数据更新成功');

        return redirect('/holidays');
    }

    public function holidays_delete(Request $request) {
        $date = Carbon::parse($request->input('month'));
        $year = $date->year;
        $month = $date->month;

        $deleted_holidays = HolidayDate::where('year', '=', $year)
                                        ->where('month', '=', $month)
                                        ->delete();

        $request->session()->flash('flash_success', '节假日数据删除成功');

        return redirect('/holidays');
    }

    public function timeedit() {
        $timenodes = TimeNode::all();

        return view('timeedit', [
            'timenodes' => $timenodes,
        ]);
    }
}
