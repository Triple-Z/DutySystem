<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Employee;
use App\User;
use App\Record;

class IndexController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        // $users = User::all();
        // $employees = Employee::all();
        // $records = Record::all();
        $all = Record::latest('check_time')->paginate(15);
        // $all->withPath('');

        return view('welcome', [
            'records' => $all,
        ]);
    }

    public function search($start_time, $end_time) {
        $records = Record::where('check_time', '>', $start_time)
                            ->where('check_time', '<', $end_time)
                            ->latest('check_time')
                            ->paginate(15);
        return view('welcome', [
            'records' => $records,
        ]);
    }
}
