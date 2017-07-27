<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Employee;

class EmployeeController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function show_all() {
        $employees = Employee::all();
        return response()->json($employees);
    }

    // show employee information
    public function show_info($work_number) {
        $employees = Employee::where('name', '=', $name)->get();
        return response()->json($employees);
    }

    public function show_records($work_number) {
        $employee = Employee::where('work_number', '=', $work_number)->first();
        $records = $employee->records()->latest('check_time')->paginate(15);
        return view('employee', [
            'records' => $records,
        ]);
    }

    
}
