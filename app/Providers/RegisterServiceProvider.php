<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;
use Xpressengine\Register\Container;

class RegisterServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Container::class, function ($app) {
            $container = $app['xe.interception']->proxy(Container::class, 'XeRegister');
            return new $container(Arr::class);
        });
        $this->app->alias(Container::class, 'xe.register');
    }
}
