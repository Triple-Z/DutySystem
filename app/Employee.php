<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

define("OUT", 0);
define("IN", 1);

class Employee extends Model
{
    // protected $connection = 'mysql';
    // protected $connection = 'sqlsrv';

    protected $table = 'employees';

    protected $fillable = [
        'name', 
        'gender', 
        'email', 
        'phone_number',
        'work_number',
        'work_title', 
        'department', 
        'car_number',
        'card_uid',
        'created_at', 
        'updated_at',
    ];

    protected $guarded = [
        'id',
    ];

    public function records() {
        return $this->hasMany('App\Record', 'employee_id', 'id');
    }

    public function special_records() {
        // default timezone is "Asia/Shanghai"

        $now = Carbon::now('Asia/Shanghai');
        
        // Load time from db
        $am_start_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'am_start')
                        ->first();
        $am_start = Carbon::create(null, null, null, $am_start_timeNode->hour, $am_start_timeNode->minute, $am_start_timeNode->second);
        if ($am_start_timeNode->day) {
            $am_start->addDays($am_start_timeNode->day);
        }
        
        $am_end_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'am_end')
                        ->first();
        $am_end = Carbon::create(null, null, null, $am_end_timeNode->hour, $am_end_timeNode->minute, $am_end_timeNode->second);
        if ($am_end_timeNode->day) {
            $am_end->addDays($am_end_timeNode->day);
        }

		$pm_start_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'pm_start')
                        ->first();
        $pm_start = Carbon::create(null, null, null, $pm_start_timeNode->hour, $pm_start_timeNode->minute, $pm_start_timeNode->second);
        if ($pm_start_timeNode->day) {
            $pm_start->addDays($pm_start_timeNode->day);
        }
        
        $pm_end_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'pm_end')
                        ->first();
        $pm_end = Carbon::create(null, null, null, $pm_end_timeNode->hour, $pm_end_timeNode->minute, $pm_end_timeNode->second);
        if ($pm_end_timeNode->day) {
            $pm_end->addDays($pm_end_timeNode->day);
        }
        
        $am_ddl_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'am_ddl')
                        ->first();
        $am_ddl = Carbon::create(null, null, null, $am_ddl_timeNode->hour, $am_ddl_timeNode->minute, $am_ddl_timeNode->second);
        if ($am_ddl_timeNode->day) {
            $am_ddl->addDays($am_ddl_timeNode->day);
        }
        
        $am_late_ddl_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'am_late_ddl')
                        ->first();
        $am_late_ddl = Carbon::create(null, null, null, $am_late_ddl_timeNode->hour, $am_late_ddl_timeNode->minute, $am_late_ddl_timeNode->second);
        if ($am_late_ddl_timeNode->day) {
        	$am_late_ddl->addDays($am_late_ddl_timeNode->day);
        }
        
        $pm_ddl_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'pm_ddl')
                        ->first();
        $pm_ddl = Carbon::create(null, null, null, $pm_ddl_timeNode->hour, $pm_ddl_timeNode->minute, $pm_ddl_timeNode->second);
        if ($pm_ddl_timeNode->day) {
            $pm_ddl->addDays($pm_ddl_timeNode->day);
        }
        
        $pm_early_ddl_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'pm_early_ddl')
                        ->first();
        $pm_early_ddl = Carbon::create(null, null, null, $pm_early_ddl_timeNode->hour, $pm_early_ddl_timeNode->minute, $pm_early_ddl_timeNode->second);
        if ($pm_early_ddl_timeNode->day) {
            $pm_early_ddl->addDays($pm_early_ddl_timeNode->day);
        }
        
        $pm_away_timeNode = DB::table('time_nodes')
                         ->where('name', '=', 'pm_away')
                         ->first();
        $pm_away = Carbon::create(null, null, null, $pm_away_timeNode->hour, $pm_away_timeNode->minute, $pm_away_timeNode->second);
        if ($pm_away_timeNode->day) {
            $pm_away->addDays($pm_away_timeNode->day);
        }

        // $am_start           = Carbon::create(null, null, null, 3, 0, 0);
        // $am_end             = Carbon::create(null, null, null, 14, 0, 0);
        // $pm_start           = Carbon::create(null, null, null, 11, 59, 59);
        // $pm_end             = Carbon::create(null, null, null, 3, 0, 0)->addDays(1);

        // $am_ddl         = Carbon::create(null, null, null, 8, 0, 0);
        // $am_late_ddl    = Carbon::create(null, null, null, 10, 0, 0);
        // $pm_ddl         = Carbon::create(null, null, null, 14, 0, 0);
        // $pm_early_ddl    = Carbon::create(null, null, null, 16, 0, 0);
        // $pm_away        = Carbon::create(null, null, null, 17, 59, 59);

        // AM
        $today_am_records = DB::table('records')
                                ->where('employee_id', '=', $this->id)
                                ->where('check_time', '<=', $am_end)
                                ->where('check_time', '>=', $am_start)
                                ->get();
        
        $today_am_earliest_record = $today_am_records
                                ->where('check_direction', '=', IN)
                                ->sortBy('check_time')
                                ->first();

        $today_am_latest_record = $today_am_records
                                ->where('check_direction', '=', OUT)
                                ->sortByDesc('check_time')
                                ->first();

        // PM
        $today_pm_records = DB::table('records')
                                ->where('employee_id', '=', $this->id)
                                ->where('check_time', '<=', $pm_end)
                                ->where('check_time', '>=', $pm_start)
                                ->get();

        $today_pm_earliest_record = $today_pm_records
                                ->where('check_direction', '=', IN)
                                ->sortBy('check_time')
                                ->first();

        $today_pm_latest_record = $today_pm_records
                                ->where('check_direction', '=', OUT)
                                ->sortByDesc('check_time')
                                ->first();

        // Note
        $notes = DB::table('records')
                ->where('employee_id', '=', $this->id)
                ->where('check_time', '<=', $pm_end)
                ->where('check_time', '>=', $am_start)
                ->select('note')
                ->get();

        $note_all = null;
        foreach ($notes as $note) {
            if ($note->note) {
                $note_all .= ' ' . $note->note;
            }
        }

        // Check status
        $check_status = null;
        if ($today_am_earliest_record && $today_pm_latest_record) {
            // Records valid
            if (Carbon::parse($today_am_earliest_record->check_time)->between($am_start, $am_ddl)) { 
                // AM in-check valid
                if (Carbon::parse($today_pm_latest_record->check_time)->between($pm_away, $pm_end)) { 
                    // PM out-check valid
                    if (strcmp($today_am_earliest_record->check_method, "car") && strcmp($today_am_earliest_record->check_method, "card")) { 
                        // Present invalid
                        $check_status = $today_am_earliest_record->check_method;
                    } else { 
                        // Present valid
                        $check_status = "正常";
                    }
                } else { 
                    // AM in-check valid, PM out-check invalid
                    if (Carbon::parse($today_pm_latest_record->check_time)->between($pm_early_ddl, $pm_away)) {
                        // AM in-check valid, PM out-check early
                        $check_status = "早退";
                    } else {
                        // AM in-check valid, PM out-check earlier
                        $check_status = "缺勤";
                    }
                }
            } else {
                // AM in-check invalid
                if (Carbon::parse($today_am_earliest_record->check_time)->between($am_ddl, $am_late_ddl)) {
                    // AM in-check late
                    if (Carbon::parse($today_pm_latest_record->check_time)->between($pm_away, $pm_end)) {
                        // AM in-check late, PM out-check valid
                        $check_status = "迟到";
                    } else {
                        // AM in-check late, PM out-check invalid
                        if (Carbon::parse($today_pm_latest_record->check_time)->between($pm_early_ddl, $pm_away)) {
                            // AM in-check late, PM out-check early
                            $check_status = "迟到早退";
                        } else {
                            // AM in-check late, PM out-check earlier
                            $check_status = "缺勤";
                        }
                    }
                } else {
                    // AM in-check later
                    $check_status = "缺勤";
                }
            }
        } else {
            // Records invalid
            $check_status = "暂无";
        }




        $special_records = array(
            "today_am_earliest_record"     => $today_am_earliest_record,
            "today_am_latest_record"       => $today_am_latest_record,
            "today_pm_earliest_record"     => $today_pm_earliest_record,
            "today_pm_latest_record"       => $today_pm_latest_record,
            "check_status"                 => $check_status,
            "note"                         => $note_all,
        );

        return $special_records;
    }

    public function special_records_date($date) {
        // default timezone is "Asia/Shanghai"

        $today = Carbon::parse($date);
        $year = $today->year;
        $month = $today->month;
        $day = $today->day;
        
        // Load time from db
        $am_start_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'am_start')
                        ->first();
        $am_start = Carbon::create($year, $month, $day, $am_start_timeNode->hour, $am_start_timeNode->minute, $am_start_timeNode->second);
        if ($am_start_timeNode->day) {
            $am_start->addDays($am_start_timeNode->day);
        }
        
        $am_end_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'am_end')
                        ->first();
        $am_end = Carbon::create($year, $month, $day, $am_end_timeNode->hour, $am_end_timeNode->minute, $am_end_timeNode->second);
        if ($am_end_timeNode->day) {
            $am_end->addDays($am_end_timeNode->day);
        }

		$pm_start_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'pm_start')
                        ->first();
        $pm_start = Carbon::create($year, $month, $day, $pm_start_timeNode->hour, $pm_start_timeNode->minute, $pm_start_timeNode->second);
        if ($pm_start_timeNode->day) {
            $pm_start->addDays($pm_start_timeNode->day);
        }
        
        $pm_end_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'pm_end')
                        ->first();
        $pm_end = Carbon::create($year, $month, $day, $pm_end_timeNode->hour, $pm_end_timeNode->minute, $pm_end_timeNode->second);
        if ($pm_end_timeNode->day) {
            $pm_end->addDays($pm_end_timeNode->day);
        }
        
        $am_ddl_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'am_ddl')
                        ->first();
        $am_ddl = Carbon::create($year, $month, $day, $am_ddl_timeNode->hour, $am_ddl_timeNode->minute, $am_ddl_timeNode->second);
        if ($am_ddl_timeNode->day) {
            $am_ddl->addDays($am_ddl_timeNode->day);
        }
        
        $am_late_ddl_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'am_late_ddl')
                        ->first();
        $am_late_ddl = Carbon::create($year, $month, $day, $am_late_ddl_timeNode->hour, $am_late_ddl_timeNode->minute, $am_late_ddl_timeNode->second);
        if ($am_late_ddl_timeNode->day) {
        	$am_late_ddl->addDays($am_late_ddl_timeNode->day);
        }
        
        $pm_ddl_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'pm_ddl')
                        ->first();
        $pm_ddl = Carbon::create($year, $month, $day, $pm_ddl_timeNode->hour, $pm_ddl_timeNode->minute, $pm_ddl_timeNode->second);
        if ($pm_ddl_timeNode->day) {
            $pm_ddl->addDays($pm_ddl_timeNode->day);
        }
        
        $pm_early_ddl_timeNode = DB::table('time_nodes')
                        ->where('name', '=', 'pm_early_ddl')
                        ->first();
        $pm_early_ddl = Carbon::create($year, $month, $day, $pm_early_ddl_timeNode->hour, $pm_early_ddl_timeNode->minute, $pm_early_ddl_timeNode->second);
        if ($pm_early_ddl_timeNode->day) {
            $pm_early_ddl->addDays($pm_early_ddl_timeNode->day);
        }
        
        $pm_away_timeNode = DB::table('time_nodes')
                         ->where('name', '=', 'pm_away')
                         ->first();
        $pm_away = Carbon::create($year, $month, $day, $pm_away_timeNode->hour, $pm_away_timeNode->minute, $pm_away_timeNode->second);
        if ($pm_away_timeNode->day) {
            $pm_away->addDays($pm_away_timeNode->day);
        }

        // $am_start           = Carbon::create(null, null, null, 3, 0, 0);
        // $am_end             = Carbon::create(null, null, null, 14, 0, 0);
        // $pm_start           = Carbon::create(null, null, null, 11, 59, 59);
        // $pm_end             = Carbon::create(null, null, null, 3, 0, 0)->addDays(1);

        // $am_ddl         = Carbon::create(null, null, null, 8, 0, 0);
        // $am_late_ddl    = Carbon::create(null, null, null, 10, 0, 0);
        // $pm_ddl         = Carbon::create(null, null, null, 14, 0, 0);
        // $pm_early_ddl    = Carbon::create(null, null, null, 16, 0, 0);
        // $pm_away        = Carbon::create(null, null, null, 17, 59, 59);

        // AM
        $today_am_records = DB::table('records')
                                ->where('employee_id', '=', $this->id)
                                ->where('check_time', '<=', $am_end)
                                ->where('check_time', '>=', $am_start)
                                ->get();
        
        $today_am_earliest_record = $today_am_records
                                ->where('check_direction', '=', IN)
                                ->sortBy('check_time')
                                ->first();

        $today_am_latest_record = $today_am_records
                                ->where('check_direction', '=', OUT)
                                ->sortByDesc('check_time')
                                ->first();

        // PM
        $today_pm_records = DB::table('records')
                                ->where('employee_id', '=', $this->id)
                                ->where('check_time', '<=', $pm_end)
                                ->where('check_time', '>=', $pm_start)
                                ->get();

        $today_pm_earliest_record = $today_pm_records
                                ->where('check_direction', '=', IN)
                                ->sortBy('check_time')
                                ->first();

        $today_pm_latest_record = $today_pm_records
                                ->where('check_direction', '=', OUT)
                                ->sortByDesc('check_time')
                                ->first();

        // Note
        $notes = DB::table('records')
                ->where('employee_id', '=', $this->id)
                ->where('check_time', '<=', $pm_end)
                ->where('check_time', '>=', $am_start)
                ->select('note')
                ->get();

        $note_all = null;
        foreach ($notes as $note) {
            if ($note->note) {
                $note_all .= ' ' . $note->note;
            }
        }

        // Check status
        $check_status = null;
        if ($today_am_earliest_record && $today_pm_latest_record) {
            // Records valid
            if (Carbon::parse($today_am_earliest_record->check_time)->between($am_start, $am_ddl)) { 
                // AM in-check valid
                if (Carbon::parse($today_pm_latest_record->check_time)->between($pm_away, $pm_end)) { 
                    // PM out-check valid
                    if (strcmp($today_am_earliest_record->check_method, "car") && strcmp($today_am_earliest_record->check_method, "card")) { 
                        // Present invalid
                        $check_status = $today_am_earliest_record->check_method;
                    } else { 
                        // Present valid
                        $check_status = "正常";
                    }
                } else { 
                    // AM in-check valid, PM out-check invalid
                    if (Carbon::parse($today_pm_latest_record->check_time)->between($pm_early_ddl, $pm_away)) {
                        // AM in-check valid, PM out-check early
                        $check_status = "早退";
                    } else {
                        // AM in-check valid, PM out-check earlier
                        $check_status = "缺勤";
                    }
                }
            } else {
                // AM in-check invalid
                if (Carbon::parse($today_am_earliest_record->check_time)->between($am_ddl, $am_late_ddl)) {
                    // AM in-check late
                    if (Carbon::parse($today_pm_latest_record->check_time)->between($pm_away, $pm_end)) {
                        // AM in-check late, PM out-check valid
                        $check_status = "迟到";
                    } else {
                        // AM in-check late, PM out-check invalid
                        if (Carbon::parse($today_pm_latest_record->check_time)->between($pm_early_ddl, $pm_away)) {
                            // AM in-check late, PM out-check early
                            $check_status = "迟到早退";
                        } else {
                            // AM in-check late, PM out-check earlier
                            $check_status = "缺勤";
                        }
                    }
                } else {
                    // AM in-check later
                    $check_status = "缺勤";
                }
            }
        } else {
            // Records invalid
            $check_status = "暂无";
        }




        $special_records = array(
            "today_am_earliest_record"     => $today_am_earliest_record,
            "today_am_latest_record"       => $today_am_latest_record,
            "today_pm_earliest_record"     => $today_pm_earliest_record,
            "today_pm_latest_record"       => $today_pm_latest_record,
            "check_status"                 => $check_status,
            "note"                         => $note_all,
        );

        return $special_records;
    }

    public function month_report_data($date) {
        
        // $now = Carbon::now('Asia/Shanghai');

        $select_month = Carbon::parse($date);

        $year = $select_month->year;
        $month = $select_month->month;


        $daily_results = DB::table('daily_check_status')
                            ->where('employee_id', '=', $this->id)
                            ->whereYear('date', $year)
                            ->whereMonth('date', $month)
                            ->get();
        
        $normal = 0;
        $late = 0;
        $early_leave = 0;
        $absence_invalid = 0;
        $absence_valid_ill = 0;
        $absence_valid_work = 0;
        $unknown = 0;

        foreach ($daily_results as $daily_result) {
            switch ($daily_result->status) {
                case "正常":
                    $normal++;
                    break;
                case "迟到":
                    $late++;
                    break;
                case "早退":
                    $early_leave++;
                    break;
                case "迟到早退":
                    $late++;
                    $early_leave++;
                    break;
                case "缺勤":
                    $absence_invalid++;
                    break;
                case "事假":
                    $absence_valid_work++;
                    break;
                case "病假":
                    $absence_valid_ill++;
                    break;
                default:
                    $unknown++;
            }
        }
       
        $data = array(
            'normal' => $normal,
            'late' => $late,
            'early_leave' => $early_leave,
            'absence_invalid' => $absence_invalid,
            'absence_valid_ill' => $absence_valid_ill,
            'absence_valid_work' => $absence_valid_work,
            'unknown' => $unknown,
        );

        return $data;
    }

}
