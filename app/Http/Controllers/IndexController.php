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
        $records = Record::latest('check_time')->paginate(15);
        $records->withPath('records');

        return view('welcome', [
            // 'users' => $users,
            // 'employees' => $employees,
            'records' => $records,
        ]);
    }
}
