<?php
/**
 * This file is Temporary package service provider.
 *
 * @category    Temporary
 * @package     Xpressengine\Temporary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Temporary\TemporaryHandler;
use Xpressengine\Temporary\TemporaryRepository;

/**
 * laravel 에서의 사용을 위한 등록 처리
 *
 * @category    Temporary
 * @package     Xpressengine\Temporary
 */
class TemporaryServiceProvider extends ServiceProvider
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
        $this->app->bind(
            'xe.temporary',
            function ($app) {
                $proxyClass = $app['xe.interception']->proxy(TemporaryHandler::class, 'XeTemporary');
                return new $proxyClass(
                    new TemporaryRepository($app['xe.db']->connection(), $app['xe.keygen']), $app['auth']
                );
            },
            true
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.temporary'];
    }
}
