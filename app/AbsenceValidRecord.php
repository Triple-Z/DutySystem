<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbsenceValidRecord extends Model
{
    protected $table = 'absence_valid_records';

    protected $connection = 'mysql';

    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'day',
        'type',
        'note',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function employee() {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }
}
