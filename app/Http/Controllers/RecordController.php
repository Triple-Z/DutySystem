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
        $records = Record::latest('check_time')->get();
        return response()->json($records);
    }
}
