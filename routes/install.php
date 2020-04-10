<?php
/**
 * install.php
 *
 * PHP version 7
 *
 * @category    Routes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

Route::get('/', ['as' => 'install.index', 'uses' => 'InstallController@index']);
Route::post('post', ['as' => 'install.post', 'uses' => 'InstallController@install']);
Route::get('check', ['as' => 'install.check', 'uses' => 'InstallController@check']);