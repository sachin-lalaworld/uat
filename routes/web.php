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

Route::prefix('telegram')->group(function () {
    Route::get('set', 'BotController@set');
    Route::get('path', 'BotController@path');
    Route::get('run', 'BotController@run');
    Route::post('hook', 'BotController@hook');
});
