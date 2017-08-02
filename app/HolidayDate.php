<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayDate extends Model
{
    protected $table = 'holiday_dates';

    // public $timestamps = false;

    protected $fillable = [
        'year',
        'month',
        'day',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
}
