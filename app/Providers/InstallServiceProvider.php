<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category  Install
 * @package   Xpressengine\Install
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Route;

/**
 * Install Service Provider
 *
 * @category Install
 * @package  Xpressengine\Install
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
            return redirect('/web_installer');
        });

        Route::post('/install/post', '\App\Http\Controllers\InstallController@install');

        \App\Http\Middleware\ExceptAppendableVerifyCsrfToken::setExcept('/install/post');

        // 실제 키 생성전 임시
        app('config')->set('app.key', Str::random(32));
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
