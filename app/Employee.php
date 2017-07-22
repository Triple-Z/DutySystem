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
        'work_title', 
        'department', 
        'car_number',
    ];

    protected $fillable = [
        'created_at', 
        'updated_at',
    ];

}
