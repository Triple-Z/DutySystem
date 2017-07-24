<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Record;

class RecordController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function show_records() {
        // $records = Record::latest('check_time')->paginate(15);
        // $records->withPath('records');// custom page url -> `records?page=x`
        // return response()->json($records);
        $record = Record::find(1)->first();
        $employee = $record->employee;
        return $employee->name;
    }
}
