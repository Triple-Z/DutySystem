<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    	if (Auth::check()) {
    		return view('welcome');
    	}
    	else {
    		return redirect()->route('login');
    	}
});

Auth::routes();

Route::get('home', 'HomeController@index');

Route::get('superhome', 'SuperHomeController@index');

Route::get('graph', function(){
	if(Auth::check()) {
		echo '<h1> Check passed!</p>';
		return view('graph');
	} else {
		return redirect('login');
	}
});

Route::get('correct', function(){
	if (Auth::check()) {
		return view('correct');
	} else {
		return redirect('login');
	}
});

Route::get('export', function(){
	if (Auth::check()) {
		return view('export');
	} else {
		return redirect('login');
	}
});

Route::get('holiday', function(){
	if (Auth::check()) {
		return view('holiday');
	} else {
		return redirect('login');
	}
});

Route::get('timeedit', function(){
	if (Auth::check()) {
		return view('timeedit');
	} else {
		return redirect('login');
	}
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

/*Route::get('api/user',function(){
	return view('welcome');
})->middleware('auth.basic.once');
*/
// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
