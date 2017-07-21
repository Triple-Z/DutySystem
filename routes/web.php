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

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Route::get('api/user',function(){
	return view('welcome');
})->middleware('auth.basic.once');
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
