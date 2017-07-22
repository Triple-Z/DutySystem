<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function graph() {
        return view('graph');
    }

    public function correct() {
        return view('correct');
    }

    public function export() {
        return view('export');
    }

    public function holiday() {
        return view('holiday');
    }

    public function timeedit() {
        return view('timeedit');
    }
}
