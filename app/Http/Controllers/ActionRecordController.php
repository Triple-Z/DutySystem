<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ActionRecord;

class ActionRecordController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function show_all_action_records() {
        $action_records = ActionRecord::latest('timestamp')->get();
        return response()->json($action_records);
    }

}
