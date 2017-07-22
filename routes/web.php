<?php

Route::get('/', function () {
	return view('welcome');
})->middleware('auth');

Auth::routes();

Route::get('home', 'HomeController@index');

Route::get('superhome', 'HomeController@superadmin');

// 
Route::group(['middleware' => 'auth'], function(){
	Route::get('graph', 'RouteController@graph');
	Route::get('correct', 'RouteController@correct');
	Route::get('export', 'RouteController@export');
	Route::get('holiday', 'RouteController@holiday');
	Route::get('timeedit', 'RouteController@timeedit');
});

// Route for test SQL Server connection;
Route::get('test', function(){
	$employees = DB::connection('sqlsrv')->select('select * from employees');
	return view('test', ['employees' => $employees]);
});

// Routes for employee information;
Route::group(['middleware' => 'auth'], function() {
	Route::get('employee/{id}', 'EmployeeController@show');
});