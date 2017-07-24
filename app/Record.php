<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    // No need created_at & updated_at
    public $timestamps = false;

    public function employee() {
        $this->hasOne('App\Employee', 'employee_id', 'id');
    }

}
