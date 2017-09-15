<?php

Route::get('/', ['as' => 'install.index', 'uses' => 'InstallController@index']);
Route::post('post', ['as' => 'install.post', 'uses' => 'InstallController@install']);
Route::get('check', ['as' => 'install.check', 'uses' => 'InstallController@check']);