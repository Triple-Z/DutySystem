<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TimeNode;

class TimeNodeController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function update(Request $request) {
        // am_start
        $am_start_day       = $request->input('am_start_day');
        $am_start_hour      = $request->input('am_start_hour');
        $am_start_minute    = $request->input('am_start_minute');
        $am_start_second    = $request->input('am_start_second');

        $am_start = TimeNode::where('name', '=', 'am_start')
                            ->first();

        $am_start->day      = $am_start_day;
        $am_start->hour     = $am_start_hour;
        $am_start->minute   = $am_start_minute;
        $am_start->second   = $am_start_second;

        $am_start->save();

        // am_end
        $am_end_day       = $request->input('am_end_day');
        $am_end_hour      = $request->input('am_end_hour');
        $am_end_minute    = $request->input('am_end_minute');
        $am_end_second    = $request->input('am_end_second');

        $am_end =TimeNode::where('name', '=', 'am_end')
                          ->first();

        $am_end->day      = $am_end_day;
        $am_end->hour     = $am_end_hour;
        $am_end->minute   = $am_end_minute;
        $am_end->second   = $am_end_second;

        $am_end->save();

        // pm_start
        $pm_start_day       = $request->input('pm_start_day');
        $pm_start_hour      = $request->input('pm_start_hour');
        $pm_start_minute    = $request->input('pm_start_minute');
        $pm_start_second    = $request->input('pm_start_second');

        $pm_start = TimeNode::where('name', '=', 'pm_start')
                            ->first();

        $pm_start->day      = $pm_start_day;
        $pm_start->hour     = $pm_start_hour;
        $pm_start->minute   = $pm_start_minute;
        $pm_start->second   = $pm_start_second;

        $pm_start->save();

        // pm_end
        $pm_end_day       = $request->input('pm_end_day');
        $pm_end_hour      = $request->input('pm_end_hour');
        $pm_end_minute    = $request->input('pm_end_minute');
        $pm_end_second    = $request->input('pm_end_second');

        $pm_end = TimeNode::where('name', '=', 'pm_end')
                            ->first();

        $pm_end->day      = $pm_end_day;
        $pm_end->hour     = $pm_end_hour;
        $pm_end->minute   = $pm_end_minute;
        $pm_end->second   = $pm_end_second;

        $pm_end->save();

        // am_ddl
        $am_ddl_day       = $request->input('am_ddl_day');
        $am_ddl_hour      = $request->input('am_ddl_hour');
        $am_ddl_minute    = $request->input('am_ddl_minute');
        $am_ddl_second    = $request->input('am_ddl_second');

        $am_ddl = TimeNode::where('name', '=', 'am_ddl')
                            ->first();

        $am_ddl->day      = $am_ddl_day;
        $am_ddl->hour     = $am_ddl_hour;
        $am_ddl->minute   = $am_ddl_minute;
        $am_ddl->second   = $am_ddl_second;

        $am_ddl->save();

        // am_late_ddl
        $am_late_ddl_day       = $request->input('am_late_ddl_day');
        $am_late_ddl_hour      = $request->input('am_late_ddl_hour');
        $am_late_ddl_minute    = $request->input('am_late_ddl_minute');
        $am_late_ddl_second    = $request->input('am_late_ddl_second');

        $am_late_ddl = TimeNode::where('name', '=', 'am_late_ddl')
                            ->first();

        $am_late_ddl->day      = $am_late_ddl_day;
        $am_late_ddl->hour     = $am_late_ddl_hour;
        $am_late_ddl->minute   = $am_late_ddl_minute;
        $am_late_ddl->second   = $am_late_ddl_second;

        $am_late_ddl->save();

        // pm_ddl
        $pm_ddl_day       = $request->input('pm_ddl_day');
        $pm_ddl_hour      = $request->input('pm_ddl_hour');
        $pm_ddl_minute    = $request->input('pm_ddl_minute');
        $pm_ddl_second    = $request->input('pm_ddl_second');

        $pm_ddl = TimeNode::where('name', '=', 'pm_ddl')
                            ->first();

        $pm_ddl->day      = $pm_ddl_day;
        $pm_ddl->hour     = $pm_ddl_hour;
        $pm_ddl->minute   = $pm_ddl_minute;
        $pm_ddl->second   = $pm_ddl_second;

        $pm_ddl->save();

        // pm_early_ddl
        $pm_early_ddl_day       = $request->input('pm_early_ddl_day');
        $pm_early_ddl_hour      = $request->input('pm_early_ddl_hour');
        $pm_early_ddl_minute    = $request->input('pm_early_ddl_minute');
        $pm_early_ddl_second    = $request->input('pm_early_ddl_second');

        $pm_early_ddl = TimeNode::where('name', '=', 'pm_early_ddl')
                            ->first();

        $pm_early_ddl->day      = $pm_early_ddl_day;
        $pm_early_ddl->hour     = $pm_early_ddl_hour;
        $pm_early_ddl->minute   = $pm_early_ddl_minute;
        $pm_early_ddl->second   = $pm_early_ddl_second;

        $pm_early_ddl->save();

        // pm_away
        $pm_away_day       = $request->input('pm_away_day');
        $pm_away_hour      = $request->input('pm_away_hour');
        $pm_away_minute    = $request->input('pm_away_minute');
        $pm_away_second    = $request->input('pm_away_second');

        $pm_away = TimeNode::where('name', '=', 'pm_away')
                            ->first();

        $pm_away->day      = $pm_away_day;
        $pm_away->hour     = $pm_away_hour;
        $pm_away->minute   = $pm_away_minute;
        $pm_away->second   = $pm_away_second;

        $pm_away->save();
        
        $request->session()->flash('flash_success', '修改成功');
        $request->session()->flash('flash_important', true);

        return redirect('/timeedit');
    }
}
