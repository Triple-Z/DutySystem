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
        $morning_start      = Carbon::create(null, null, null, 3, 0, 0, 'Asia/Shanghai');
        $morning_end        = Carbon::create(null, null, null, 14, 0, 0, 'Asia/Shanghai');
        $afternoon_start    = Carbon::create(null, null, null, 11, 59, 59, 'Asia/Shanghai');
        $afternoon_end      = Carbon::create(null, null, null, 18, 0, 0, 'Asia/Shanghai');
        $evening_start      = Carbon::create(null, null, null, 17, 59, 59, 'Asia/Shanghai');
        $evening_end        = Carbon::create(null, null, null, 3, 0, 0, 'Asia/Shanghai')->addDay();

        // Morning
        $today_morning_records = DB::table('records')
                                ->where('employee_id', '=', $this->id)
                                ->where('check_time', '<=', $morning_end)
                                ->where('check_time', '>=', $morning_start)
                                ->get();
        
        $today_morning_earliest_record = $today_morning_records
                                ->where('check_direction', '=', IN)
                                ->sortBy('check_time')
                                ->first();

        $today_morning_latest_record = $today_morning_records
                                ->where('check_direction', '=', OUT)
                                ->sortByDesc('check_time')
                                ->first();

        // Afternoon
        $today_afternoon_records = DB::table('records')
                                ->where('employee_id', '=', $this->id)
                                ->where('check_time', '<=', $afternoon_end)
                                ->where('check_time', '>=', $afternoon_start)
                                ->get();

        $today_afternoon_earliest_record = $today_afternoon_records
                                ->where('check_direction', '=', IN)
                                ->sortBy('check_time')
                                ->first();

        // Evening
        $today_evening_records = DB::table('records')
                                ->where('employee_id', '=', $this->id)
                                ->where('check_time', '<=', $evening_end)
                                ->where('check_time', '>=', $evening_start)
                                ->get();


        $today_evening_latest_record = $today_evening_records
                                ->where('check_direction', '=', OUT)
                                ->sortByDesc('check_time')
                                ->first();

        $notes = DB::table('records')
                ->where('employee_id', '=', $this->id)
                ->where('check_time', '<=', $evening_end)
                ->where('check_time', '>=', $morning_start)
                ->select('note')
                ->get();

        $note_all = null;

        foreach ($notes as $note) {
            if ($note->note) {
                $note_all .= ' ' . $note->note;
            }
        }

        $special_records = array(
            "today_morning_earliest_record"     => $today_morning_earliest_record,
            "today_morning_latest_record"       => $today_morning_latest_record,
            "today_afternoon_earliest_record"   => $today_afternoon_earliest_record,
            "today_evening_latest_record"       => $today_evening_latest_record,
            "note"                              => $note_all,
        );

        return $special_records;
    }

}
