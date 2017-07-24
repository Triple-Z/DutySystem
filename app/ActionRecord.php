<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionRecord extends Model
{
    // No need created_at & updated_at
    public $timestamps = false;

    protected $table = 'user_action_records';

    protected $fillable = [
        'user_id',
        'action',
        'timestamp'
    ];

    protected $guarded = [
        'id',
    ];

    public function user() {
        $this->hasOne('App\User', 'user_id', 'id');
    }

}
