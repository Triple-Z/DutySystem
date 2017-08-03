<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsenceValidRecord extends Model
{
    protected $table = 'absence_valid_records';

    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'day',
        'type',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
}
