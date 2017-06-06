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

Route::get('/players/since/{ageInMinutes}', 'PrivateApiController@getPlayerCounts');
Route::get('/servers/since/{ageInMinutes}', 'PrivateApiController@getServerCounts');
Route::get('/serversAndPlayers/since/{ageInMinutes}', 'PrivateApiController@getSeverAndPlayerCounts');

Route::get('/players/byCountry', 'PrivateApiController@getCountryPlayerCount');
Route::get('/servers/byCountry', 'PrivateApiController@getCountryServerCount');