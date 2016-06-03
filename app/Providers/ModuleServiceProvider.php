<?php
/**
 * Service provider
 *
 * @category  Module
 * @package   Xpressengine\Module
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Module\ModuleHandler;

/**
 * Module Service Provider
 *
 * @category Module
 * @package  Xpressengine\Module
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
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
