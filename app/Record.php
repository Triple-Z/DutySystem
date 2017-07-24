<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    // No need created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'employee_id',
        'check_direction',
        'check_method',
        'check_time',
    ];

    protected $guarded = [
        'id',
    ];

    public function employee() {
        return $this->belongsTo('App\Employee', 'employee_id', 'id');
    }

}
