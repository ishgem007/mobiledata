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
    return redirect(route('login')) ;
    // return view('welcome');
});

// Route::get('/', 'Auth\LoginController@showLoginForm ');


Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/data', 'DataController@index');
    Route::get('/data/create', 'DataController@getMonth');
    Route::get('/data/store', 'DataController@caseSwitch')->name('data.send');
    Route::get('/data/missing-data', 'DataController@missing')->name('data.missing.send');
    Route::get('/download', 'DataController@download')->name('export.excel');

    Route::get('/v2/get-data', 'GetDataController@index');
});