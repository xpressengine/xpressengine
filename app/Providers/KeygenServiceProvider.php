<?php
/**
 * This file is service register for laravel framework
 *
 * PHP version 5
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Keygen\Keygen;

/**
 * laravel에서의 사용을 위한 등록 처리를 하는 class
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
