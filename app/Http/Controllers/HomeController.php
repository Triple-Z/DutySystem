<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->admin) {
            // super admin
            return redirect('superhome');
        } else {
            return view('home');
        }
    }

    public function superadmin()
    {
        return view('superhome');
    }

    public function show_action() {
        $user = Auth::user();
        $actions = $user->actions()->get();
        return response()->json($actions);
    }
    
    public function show_action_test($id) {
        // user for test...
        $user = User::where('id', '=', $id)->first();
        $actions = $user->actions()->get();
        return response()->json($actions);
    }
}
