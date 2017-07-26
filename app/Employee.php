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
        'id', 
        'name', 
        'gender', 
        'email', 
        'phone_number',
        'work_number',
        'work_title', 
        'department', 
        'car_number',
        'card_uid',
    ];

    protected $guarded = [
        'created_at', 
        'updated_at',
    ];

    public function records() {
        return $this->hasMany('App\Record', 'employee_id', 'id');
    }

    public function special_records() {

        $now = Carbon::now();

        $am_start           = Carbon::create(null, null, null, 3, 0, 0, 'Asia/Shanghai');
        $am_end             = Carbon::create(null, null, null, 14, 0, 0, 'Asia/Shanghai');
        $pm_start           = Carbon::create(null, null, null, 11, 59, 59, 'Asia/Shanghai');
        $pm_end             = Carbon::create(null, null, null, 3, 0, 0, 'Asia/Shanghai')->addDay();

        $am_ddl         = Carbon::create(null, null, null, 8, 0, 0, 'Asia/Shanghai');
        $am_late_ddl    = Carbon::create(null, null, null, 10, 0, 0, 'Asia/Shanghai');
        $pm_ddl         = Carbon::create(null, null, null, 14, 0, 0, 'Asia/Shanghai');
        $pm_early_ddl    = Carbon::create(null, null, null, 16, 0, 0, 'Asia/Shanghai');
        $pm_away        = Carbon::create(null, null, null, 17, 59, 59, 'Asia/Shanghai');

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
        if (var_dump($today_am_earliest_record->check_time->between($am_start, $am_ddl))) { 
            // AM in-check valid
            if (var_dump($today_pm_latest_record->between($pm_away, $pm_end))) { 
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
                if (var_dump($today_pm_latest_record->between($pm_early_ddl, $pm_away))) {
                    // AM in-check valid, PM out-check early
                    $check_status = "早退";
                } else {
                    // AM in-check valid, PM out-check earlier
                    $check_status = "缺勤";
                }
            }
        } else {
            // AM in-check invalid
            if (var_dump($today_am_earliest_record->between($am_ddl, $am_late_ddl))) {
                // AM in-check late
                if (var_dump($today_pm_latest_record->between($pm_away, $pm_end))) {
                    // AM in-check late, PM out-check valid
                    $check_status = "迟到";
                } else {
                    // AM in-check late, PM out-check invalid
                    if (var_dump($today_pm_latest_record->between($pm_early_ddl, $pm_away))) {
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

}
