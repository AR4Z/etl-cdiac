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
    Route::get('search-stations', [ 'as'=>'server-acquisition.search-stations','uses'=>'Etl\ServerAcquisitionController@searchStations']);
});

Route::group(['prefix' => 'execute-etl','name' => 'execute-etl'], function()
{
    Route::get('', [ 'as'=>'execute-etl','uses'=>'Etl\ExecuteEtlController@index']);
    Route::post('getStationsForNet', [ 'as'=>'execute-etl.getStationsForNet','uses'=>'Etl\ExecuteEtlController@getStationsForNet']);
    Route::post('redirectionEtlFilter', [ 'as'=>'execute-etl.redirectionEtlFilter','uses'=>'Etl\ExecuteEtlController@redirectionEtlFilter']);

});

Route::group(['prefix' => 'search-missing','name' => 'search-missing'], function()
{
    Route::get('', [ 'as'=>'search-missing','uses'=>'Etl\SearchMissingData@index']);
    Route::post('search-data', [ 'as'=>'search-missing.search-data','uses'=>'Etl\SearchMissingData@searchData']);
    Route::post('stationsForFactTable', [ 'as'=>'search-missing.stationsForFactTable','uses'=>'Etl\SearchMissingData@stationsForFactTable']);
});

Route::group(['prefix' => 'auditory','name' => 'auditory'], function()
{
    Route::get('/', [ 'as'=>'auditory','uses'=>'Auditory\AuditoryController@index']);
    Route::post('make-auditory', [ 'as'=>'auditory.make-auditory','uses'=>'Auditory\AuditoryController@makeAuditory']);
    Route::post('apply-auditory', [ 'as'=>'auditory.apply-auditory','uses'=>'Auditory\AuditoryController@applyAuditory']);
    Route::post('graphics', [ 'as'=>'auditory.graphics','uses'=>'Auditory\AuditoryController@graphics']);
    Route::get('generate-risk', [ 'as'=>'auditory.generate-risk','uses'=>'Auditory\AuditoryController@generateRisk']);
    Route::post('save-risk', [ 'as'=>'auditory.save-risk','uses'=>'Auditory\AuditoryController@saveRisk']);
});

Route::group(['prefix' => 'users','name' => 'users'], function()
{
    Route::get('/', [ 'as'=>'login','uses'=>'Auth\LoginController@index']);
    Route::get('/', [ 'as'=>'register','uses'=>'Auth\RegisterController@index']);
    Route::post('create_user', [ 'as'=>'users.create_user','uses'=>'Auth\RegisterController@create']);
});
