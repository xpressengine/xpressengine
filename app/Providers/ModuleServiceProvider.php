<?php
/**
 * Service provider
 *
 * @category  Module
 * @package   Xpressengine\Module
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Module\ModuleHandler;

/**
 * Module Service Provider
 *
 * @category Module
 * @package  Xpressengine\Module
 */
class ModuleServiceProvider extends ServiceProvider
{

    /**
     * Service Provider Boot
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'xe.module',
            function ($app) {
                $register = $app['xe.pluginRegister'];
                $proxyClass = $app['xe.interception']->proxy(ModuleHandler::class, 'Module');
                return new $proxyClass($register);
            }
        );

        $this->app->bind(
            'Xpressengine\Module\ModuleHandler',
            'xe.module'
        );
    }
}
