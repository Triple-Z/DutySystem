<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardRecord extends Model
{
    public $timestamps = false;

    protected $table = 'card_records';

    protected $fillable = [
        'card_uid',
        'direction',
        'timestamp',
    ];

    protected $guarded = [
        'id',
    ];

    public function employee() {
        return $this->hasOne('App\Employee', 'card_uid', 'card_uid');
    }
}
