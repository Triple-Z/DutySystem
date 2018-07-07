<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    // No need created_at & updated_at
    // public $timestamps = false;

    protected $connection = 'mysql';

    protected $fillable = [
        'employee_id',
        'check_direction',
        'check_method',
        'check_time',
        'card_gate',
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
