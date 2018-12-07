<?php
/**
 * install.php
 *
 * PHP version 7
 *
 * @category    Routes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

Route::get('/', ['as' => 'install.index', 'uses' => 'InstallController@index']);
Route::post('post', ['as' => 'install.post', 'uses' => 'InstallController@install']);
Route::get('check', ['as' => 'install.check', 'uses' => 'InstallController@check']);