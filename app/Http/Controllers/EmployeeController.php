<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    // show employee information
    public function show($id){
        $employee = Employee::where('id', '=', $id)->first();
        return response()->json($employee);
    }

}
