<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function validator(Request $data) {
        return Validator::make($data, [
            'password' => 'required|string|min:6|confirmed'
        ]);
    }

    public function resetPassword(Request $data){
        $success = true;
        $cur_user = Auth::user();
        $id = $cur_user->id;
        $user = User::where('id', '=', $id)->first();
        if ( Hash::check($data['oldpassword'], $user->password)){
            $user->password = bcrypt($data['password']);
            echo $user->password;
            $user->save();
        } else {
            $success = false;
        }

        if ($success) {
            $data->session()->flash('flash_success', '重置密码成功');
        } else {
            $data->session()->flash('flash_error', '重置密码失败：密码不正确');
        }
        return redirect('home');
    }
}
