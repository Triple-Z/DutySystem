<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AbsenceValidRecord;

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
}
