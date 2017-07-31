<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Record;
use Carbon\Carbon;
use App\TimeNode;


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

        $employees = Employee::orderBy('work_number')->paginate(15);

        return view('report', [
            'employees' => $employees,
            'date' => $date,
        ]);
    }

    // public function report_date(Request $request) {
    //     $date = $request->input('date');

    //     return view('report', [
    //         'employees' => $employees,
    //     ])
    // }

    public function holidays(Request $request) {


        return view('holiday');
    }

    public function holidays_create(Request $request) {

    }

    public function holidays_update(Request $request, $id) {

    }

    public function holidays_delete(Request $request, $id) {

    }

    public function timeedit() {
        $timenodes = TimeNode::all();

        return view('timeedit', [
            'timenodes' => $timenodes,
        ]);
    }
}
