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

        return view('holidays');

    }

    public function holidays_data(Request $request) {

        $now = Carbon::now('Asia/Shanghai');
        $year = $now->year;
        $month = $now->month;

        $holidays = HolidayDate::where('year', '=', $year)
                                ->orderBy('month')
                                ->orderBy('day')
                                ->get();

        $data = array();


        foreach ($holidays as $holiday) {
            $date = Carbon::create($holiday->year, $holiday->month, $holiday->day, null, null, null);
            array_push($data, [
                "date" => $date->toDateString()
            ]);
        }
        
        // Return JSON
        return json_encode(array(
            'year' => $year,
            'dates' => $data,
        ));

    }

    // public function holidays_content(Request $request) {
    //     $now = Carbon::now('Asia/Shanghai');
    //     $year = $now->year;
    //     $month = $now->month;

    //     $holidays = HolidayDate::where('year', '=', $year)
    //                             ->where('month', '=', $month)
    //                             ->orderBy('day')
    //                             ->get();
        
    //     // Return JSON for test
    //     // return response()->json(['date'=>'2017-08-04']);

    //     // return response()->json($holidays);

        
    //     $holidays_formatted = array();
        
    //     foreach ($holidays as $holiday) {
    //         // Format the date
    //         $temp_time = Carbon::create($holiday->year, $holiday->month, $holiday->day, null, null, null);
    //         array_push($holidays_formatted, [
    //         	'date' => $temp_time->toDateString(),
    //         ]);
    //     }
        
    //     return response()->json($holidays_formatted);
    //     // if it cannot return normal JSON array, use the code following.
    //     // return json_encode($holidays_formatted);

    // }

    public function holidays_search(Request $request) {
        $date = Carbon::parse($request->input('month'));
        $year = $date->year;
        $month = $date->month;

        $holidays = HolidayDate::where('year', '=', $year)
                                ->where('month', '=', $month)
                                ->orderBy('day')
                                ->get();

        $data = array(); // array for dates

        foreach ($holidays as $holiday) {
            $date = Carbon::create($holiday->year, $holiday->month, $holiday->day, null, null, null);
            array_push($data, [
                "date" => $date->toDateString()
            ]);
        }

        // Return JSON for test
        return json_encode(array([
            'month' => $date->format('Y-m'),
            'dates' => $data,
        ]));

        // return view('holiday', [
        //     'holidays' => $holidays,
        // ]);
    }

    public function holidays_add(Request $request) {
        $success = true;

        $date = Carbon::parse($request->input('month'));
        $year = $date->year;
        $month = $date->month;
        $maxDay = $date->addMonth()->subDay()->day;
        // echo $date;

        $newDaysString = $request->input('day');// Add holidays from JSON
        // echo "<br>" . $newDaysString;
        
        $newDays = explode(',', $newDaysString);

        // $json_array = json_decode($all, true);
        // $new_days = $json_array['dates'];

        // $deleted_holidays = HolidayDate::where('year', '=', $year)
        //                                 ->where('month', '=', $month)
        //                                 ->delete();


        if (!is_numeric($newDays[0])) {
            $success = false;
            $request->session()->flash('flash_error', '节假日数据添加失败');
        } else {
            foreach ($newDays as $day) {
                // $temp_date = Carbon::parse($holiday);
                // $h_year = $temp_date->year;
                // $h_month = $temp_date->month;
                // $h_day = $temp_date->day;

                if ($day <= 0 || $day > $maxDay) {
                    $success = false;
                    $request->session()->flash('flash_warning', '节假日数据有误');
                } else {
                    HolidayDate::create([
                        'year' => $year,
                        'month' => $month,
                        'day' => $day,
                    ]);
                }
    
            }
            
            if ($success) {
                $request->session()->flash('flash_success', '节假日数据添加成功');
            }
        }


        return redirect('/holidays');
    }

    public function holidays_delete(Request $request) {
        $date = Carbon::parse($request->input('month'));
        $year = $date->year;
        $month = $date->month;

        $deleted_days = $request->input('day');// Delete holidays from JSON

        $targetDays = explode(",", $deleted_days);

        if (!is_numeric($targetDays[0])) {
            $request->session()->flash('flash_error', '节假日数据删除失败！');
        } else {
            foreach($targetDays as $day) {// Tranverse to delete holidays
                HolidayDate::where('year', '=', $year)
                            ->where('month', '=', $month)
                            ->where('day', '=', $day)
                            ->delete();
            }
    
            $request->session()->flash('flash_success', '节假日数据删除成功');
        }

        return redirect('/holidays');
    }

    public function timeedit() {
        $timenodes = TimeNode::all();

        return view('timeedit', [
            'timenodes' => $timenodes,
        ]);
    }
}
