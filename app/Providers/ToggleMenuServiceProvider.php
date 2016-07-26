<?php
/**
 * This file is ToggleMenu package service provider.
 *
 * PHP version 5
 *
 * @category    ToggleMenu
 * @package     Xpressengine\ToggleMenu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\ToggleMenu\ToggleMenuHandler;

/**
 * laravel 에서의 사용을 위한 등록 처리
 *
 * @category    ToggleMenu
 * @package     Xpressengine\ToggleMenu
 */
class ToggleMenuServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('xe.toggleMenu', function ($app) {
            $proxyClass = $app['xe.interception']->proxy(ToggleMenuHandler::class, 'ToggleMenu');
            return new $proxyClass($app['xe.pluginRegister'], $app['xe.config'], $app);
        }, true);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.toggleMenu'];
    }
}
