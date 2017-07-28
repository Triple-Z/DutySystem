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

    public function update(Request $request, $work_number, $id) {
        if ($request->isMethod('put')) {
            // Get vars
            $check_direction = $request->input('check_direction');
            $check_method = $request->input('check_method');
            $card_gate = $request->input('card_gate');
            $note = $request->input('note');
            // Update record
            $record = Record::where('id', '=', $id)->first();
            $record->check_direction = $check_direction;
            $record->check_method = $check_method;
            $record->card_gate = $card_gate;
            $record->note = $note;

            $record->save();
        }
    }
}
