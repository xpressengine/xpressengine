<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Counter\ConfigHandler;
use Xpressengine\Counter\Counter;
use Xpressengine\Counter\Repository;
use Xpressengine\Counter\SessionCounter;

/**
 * laravel service provider
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CounterServiceProvider extends ServiceProvider
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
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('xe.counter', function ($app) {
            $connection = $app['xe.db']->connection();

            $sessionCounter = new SessionCounter(app('session.store'));
            $repo = new Repository($connection);

            $configHandler = new ConfigHandler($app['xe.config']);

            $proxyClass = $app['xe.interception']->proxy(Counter::class, 'Counter');
            $factory = new $proxyClass(
                $repo,
                $sessionCounter,
                $configHandler,
                $app['xe.members'],
                $app['xe.auth'],
                $app['request']
            );

            return $factory;
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
