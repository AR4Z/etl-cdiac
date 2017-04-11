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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'General\HomeController@index');

Route::resource('external-connection', 'Config\ExternalConnectionController');

Route::resource('station', 'Config\StationController');

Route::get('extract-all','General\EtlController@index');
