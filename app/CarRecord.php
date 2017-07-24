<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarRecord extends Model
{
    public $timestamps = false;

    protected $table = 'car_records';

    protected $fillable = [
        'car_number',
        'direction',
        'timestamp'
    ];

    protected $guarded = [
        'id',
    ];

    public function employee() {
        return $this->hasMany('App\Employee', 'car_number', 'car_number');
    }
}
