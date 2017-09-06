<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetInfoController extends Controller
{
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function resetEmail(Request $request){

        $this->validate($request, [
            'newemail' => 'required|string|email|unique:users,email',
        ]);

        $cur_user = Auth::user();
        $id = $cur_user->id;
        $user = User::where('id', '=', $id)->first();
        
        $newEmail = $request->input('newemail');
        $user->email = $newEmail;
        $user->save();

        $request->session()->flash('flash_success', '用户邮件重置成功！');

        return redirect('/home');
    }

    public function resetName(Request $request) {
        
        $this->validate($request, [
            'newname' => 'required|string|alpha_dash|unique:users,name'
        ]);

        $cur_user = Auth::user();
        $id = $cur_user->id;
        $user = User::where('id', '=', $id)->first();
        
        $newName = $request->input('newname');
        $user->name = $newName;
        $user->save();

        $request->session()->flash('flash_success', '用户名重置成功！');

        return redirect('/home');
    }
}
