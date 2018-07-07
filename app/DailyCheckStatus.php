<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyCheckStatus extends Model
{
    protected $table = 'daily_check_status';

    protected $connection = 'mysql';
    
    protected $fillable = [
        'employee_id',
        'date',
        'am_check',
        'am_away',
        'pm_check',
        'pm_away',
        'status',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
}
