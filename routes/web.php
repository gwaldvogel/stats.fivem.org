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

Route::get('/', function(){
    return redirect('/dashboard');
});
Route::get('/dashboard', 'MainController@dashboard');
Route::get('/serverlist', 'MainController@serverList');

Route::get('/serversByCountry', 'MainController@serversByCountry');
Route::get('/playersByCountry', 'MainController@playersByCountry');

Route::get('/foo', function(){
    return view('foo');
});