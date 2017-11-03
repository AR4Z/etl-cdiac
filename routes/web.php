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


Route::group(['prefix' => 'plane-etl','name' => 'plane-etl'], function()
{
    Route::get('index', [ 'as'=>'plane-etl.index','uses'=>'Etl\PlaneEtlController@index']);
    Route::post( 'getDifferentNetName',[ 'as'=>'plane-etl.getDifferentNetName','uses'=>'Etl\PlaneEtlController@getDifferentNetName']);
    Route::post('getStationsForNet', [ 'as'=>'plane-etl.getStationsForNet','uses'=>'Etl\PlaneEtlController@getStationsForNet']);
    Route::post('loadFile',[ 'as'=>'plane-etl.loadFile','uses'=>'Etl\PlaneEtlController@loadFile']);
    Route::post('loadFileErrors', [ 'as'=>'plane-etl.loadFileErrors','uses'=>'Etl\PlaneEtlController@loadFileErrors']);

});

Route::group(['prefix' => 'server-acquisition','name' => 'server-acquisition'], function()
{
    Route::get('', [ 'as'=>'server-acquisition','uses'=>'Etl\ServerAcquisitionController@index']);
    Route::post('search-data', [ 'as'=>'server-acquisition.search-data','uses'=>'Etl\ServerAcquisitionController@searchData']);
});
