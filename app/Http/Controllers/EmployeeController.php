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
    public function show_info($id) {
        $employee = Employee::where('id', '=', $id)->first();
        return response()->json($employee);
    }

    public function show_records($id) {
        $employee = Employee::where('id', '=', $id)->first();
        $records = $employee->records()->latest('check_time')->get();
        return response()->json($records);
    }

}
