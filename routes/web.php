<?php

Route::get('/', 'IndexController@index');

Auth::routes();

Route::get('home', 'HomeController@index');
Route::get('superhome', 'HomeController@superadmin');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
	Route::get('actions', 'HomeController@show_action');
	Route::get('actions_all', 'ActionRecordController@show_all_action_records');
	Route::get('actions/{id}', 'HomeController@show_action_test');
});

// ALl check in condition
Route::group(['middleware' => 'auth'], function(){
	Route::get('graph', 'RouteController@graph');
	Route::get('correct', 'RouteController@correct');
	Route::get('export', 'RouteController@export');
	Route::get('holiday', 'RouteController@holiday');
	Route::get('timeedit', 'RouteController@timeedit');
});

// Rotues for modifying admin info
Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'namespace' => 'Auth'], function(){
	Route::post('resetpassword', 'ResetPasswordController@resetPassword');
	// Route::post('resetemail', 'ResetInfoController@resetemail');
});

// Route for test SQL Server connection;
Route::get('test', function(){
	$employees = DB::connection('sqlsrv')->select('select * from employees');
	return view('test', ['employees' => $employees]);
});

// Routes for employee & record information;
Route::group(['middleware' => 'auth'], function() {
	Route::get('employees', 'EmployeeController@show_all');
	Route::get('employees/{id}', 'EmployeeController@show_info');
	Route::get('employees/{id}/records', 'EmployeeController@show_records');
	// Route::get('records', 'RecordController@show_records');
});