<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarRecord extends Model
{
    public $timestamps = false;

    protected $connection = 'mysql_read';

    protected $table = 'car_records';

    protected $fillable = [
        'car_number',
        'direction',
        'timestamp',
    ];

    protected $guarded = [
        'id',
    ];

    public function employee() {
        return $this->belongsTo('App\Employee', 'car_number', 'car_number');
    }
}
