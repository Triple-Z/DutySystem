<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ActionRecord;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function actions() {
        return $this->hasMany('App\ActionRecord', 'user_id', 'id');
    }

    public function login() {
        ActionRecord::create([
            'user_id' => $this->id,
            'action' => 'login',
            'timestamp' => Carbon::now('Asia/Shanghai'),
        ]);
    }

    public function logout() {
        ActionRecord::create([
            'user_id' => $this->id,
            'action' => 'logout',
            'timestamp' => Carbon::now('Asia/Shanghai'),
        ]);
    }
}
