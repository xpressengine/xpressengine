<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category  Install
 * @package   Xpressengine\Install
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Route;
use File;

/**
 * Install Service Provider
 *
 * @category Install
 * @package  Xpressengine\Install
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class InstallServiceProvider extends ServiceProvider
{

    /**
     * Service Provider Boot
     *
     * @return void
     */
    public function boot()
    {
        echo 'Please Install XE3';
        exit;
        $appKeyPath = storage_path('app') . '/appKey';

        if (File::exists($appKeyPath) === false) {
            File::put($appKeyPath, Str::random(32));
        }

        Route::get('/', '\App\Http\Controllers\InstallController@index');
        Route::get('/step1', '\App\Http\Controllers\InstallController@step1');
        Route::get('/checkPHP', '\App\Http\Controllers\InstallController@checkPHP');
        Route::get('/checkDirectoryPermission', '\App\Http\Controllers\InstallController@checkDirectoryPermission');
        Route::post('/install', '\App\Http\Controllers\InstallController@install');

        app('config')->set('app.key', File::get($appKeyPath));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}
