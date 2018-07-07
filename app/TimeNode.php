<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeNode extends Model
{
    protected $table = 'time_nodes';

    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'day',
        'hour',
        'minute',
        'second',
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    
}
