<?php
/**
 * This file is service register for laravel framework
 *
 * PHP version 5
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Keygen\Keygen;

/**
 * laravel에서의 사용을 위한 등록 처리를 하는 class
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 */
class KeygenServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('xe.keygen', function ($app) {
            $proxyClass = $app['xe.interception']->proxy(Keygen::class, 'Keygen');
            return new $proxyClass($app['config']['xe.uid']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.keygen'];
    }
}
