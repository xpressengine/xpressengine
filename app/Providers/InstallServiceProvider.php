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
        Route::get('/', function() {
            return redirect('/installer');
        });

        Route::get('/install', '\App\Http\Controllers\InstallController@create');
        Route::post('/install/post', '\App\Http\Controllers\InstallController@install');
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
