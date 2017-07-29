<?php

Route::get('/', 'IndexController@index');
Route::get('/s/{start_time}/e/{end_time}', 'IndexController@search');

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
	// Route::get('graph', 'RouteController@graph');
	// Route::get('correct', 'RouteController@correct');
	Route::get('valid', 'RouteController@valid');
	Route::get('valid/date/{date}', 'RouteController@valid_date');
	Route::get('report', 'RouteController@report');
	Route::get('holiday', 'RouteController@holiday');
	Route::get('timeedit', 'RouteController@timeedit');
	Route::put('timeedit/update', 'TimeNodeController@update');
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
	Route::get('employees/{work_number}', 'EmployeeController@show_records');
	Route::put('employees/{work_number}/records/{id}', 'RecordController@update');
	Route::get('records', 'RecordController@show_records');
});