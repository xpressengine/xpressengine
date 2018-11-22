<?php

Route::get('/', ['as' => '__safe_mode.index', 'uses' => 'SafeModeController@auth']);
Route::get('auth', ['as' => '__safe_mode.auth', 'uses' => 'SafeModeController@auth']);
Route::post('login', ['as' => '__safe_mode.login', 'uses' => 'SafeModeController@login']);
Route::get('logout', ['as' => '__safe_mode.logout', 'uses' => 'SafeModeController@logout']);
Route::get('dashboard', ['as' => '__safe_mode.dashboard', 'uses' => 'SafeModeController@dashboard']);
Route::post('do/cache-clear', ['as' => '__safe_mode.do.cache-clear', 'uses' => 'SafeModeController@doCacheClear']);
Route::post('do/log-clear', ['as' => '__safe_mode.do.log-clear', 'uses' => 'SafeModeController@doLogClear']);
Route::post('do/plugin-off', ['as' => '__safe_mode.do.plugin-off', 'uses' => 'SafeModeController@doPluginOff']);
Route::post('do/plugin-on', ['as' => '__safe_mode.do.plugin-on', 'uses' => 'SafeModeController@doPluginOn']);

