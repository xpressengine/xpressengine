<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Xpressengine\Database\DatabaseCoupler;
use Xpressengine\Database\DatabaseHandler;
use Xpressengine\Database\ProxyManager;
use Xpressengine\Database\TransactionHandler;
use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Support\LaravelCache;

/**
 * laravel service provider
 *
 * @category    Providers
 * @package     App\Providers
 */
class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app['config']->get('app.debug') === true) {

            \DB::listen(function ($query, $bindings, $time) {
                $logFile = storage_path('logs/query.log');
                $monoLog = new Logger('log');
                $monoLog->pushHandler(new StreamHandler($logFile, Logger::INFO));
                $monoLog->info($query, compact('bindings', 'time'));
            });
        }
        DynamicModel::setKeyGen(app('xe.keygen'));
        DynamicModel::setConnectionResolver($this->app['xe.db']);
        DynamicModel::setEventDispatcher($this->app['events']);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        DynamicModel::clearBootedModels();

        $this->app->singleton('xe.db.proxy', function ($app) {
            return ProxyManager::instance($app['xe.register']);
        });

        $this->app->singleton(['xe.db' => DatabaseHandler::class], function ($app) {

            $coupler = DatabaseCoupler::instance(
                $app['db'],
                TransactionHandler::instance(),
                $app['xe.db.proxy'],
                new LaravelCache($app['cache']->driver('schema'))
            );

            $proxyClass = $app['xe.interception']->proxy(DatabaseHandler::class, 'XeDB');
            return new $proxyClass(
                $coupler,
                $app['config']->get('xe.database')
            );
        });
    }
}
