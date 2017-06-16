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
    return redirect('/dashboard');
});
Route::get('/dashboard', 'MainController@dashboard');

// DEMOGRAPHICS
Route::get('/serversByCountry', 'MainController@serversByCountry');
Route::get('/playersByCountry', 'MainController@playersByCountry');

// SERVERS
Route::get('/serverlist', 'ServerController@serverlist');
Route::get('/server/{id}', 'ServerController@getServer');
Route::get('/search/server', 'ServerController@searchServerView');
Route::post('/search/server', 'ServerController@searchServer');

// LOGIN
Route::get('/login', 'LoginController@redirectToProvider');
Route::get('/logout', 'LoginController@logout');
Route::get('/login/callback', 'LoginController@handleProviderCallback');

// PLAYERS
Route::get('/playerlist', 'PlayerController@playerlist');
Route::get('/player/{steamdid}/{toggle?}', 'PlayerController@getPlayer');
Route::get('/search/player', 'PlayerController@searchPlayerView');
Route::post('/search/player', 'PlayerController@searchPlayer');


Route::get('/credits', function () {
    return view('credits');
});