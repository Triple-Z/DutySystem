<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // protected $connection = 'mysql';
    // protected $connection = 'sqlsrv';

    protected $table = 'employees';

    protected $guarded = [
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

    protected $fillable = [
        'created_at', 
        'updated_at',
    ];

    public function records() {
        return $this->hasMany('App\Record', 'employee_id', 'id');
    }

    public function morning_record() {
        $records = $this->hasMany('App\Record', 'employee_id', 'id')->get();
        $today_records = $records;// ......
    }

}
