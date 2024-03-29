<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'apiMap'], function()  //,'middleware' => 'auth:api'
{
    Route::post('/getStations', [ 'as'=>'apiMap.getStations','uses'=>'ApiMap\ApiMapController@getStations']);
    Route::post('/getStation',['as'=>'apiMap.getStation','uses'=>'ApiMap\ApiMapController@getStation']);
});
