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

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Xpressengine\Database\DatabaseCoupler;
use Xpressengine\Database\DatabaseHandler;
use Xpressengine\Database\ProxyManager;
use Xpressengine\Database\TransactionHandler;
use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Database\VirtualConnection;

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

            \DB::listen(function (QueryExecuted $executed) {
                $query = $executed->sql;
                $bindings = $executed->bindings;
                $time = $executed->time;
                $logFile = storage_path('logs/query.log');
                $monoLog = new Logger('log');
                $monoLog->pushHandler(new StreamHandler($logFile, Logger::INFO));
                $prep = $query;
                foreach ($bindings as $binding) {
                    $prep = preg_replace('#\?#', is_numeric($binding) ? $binding : "'" . $binding . "'", $prep, 1);
                }
                $monoLog->info($prep);
            });
        }
        DynamicModel::setKeyGen(app('xe.keygen'));
        DynamicModel::setConnectionResolver($this->app['xe.db']);
        DynamicModel::setEventDispatcher($this->app['events']);

        VirtualConnection::setCache($this->app['cache']->driver('schema'));
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

        $this->app->singleton(DatabaseHandler::class, function ($app) {

            $coupler = DatabaseCoupler::instance(
                $app['db'],
                TransactionHandler::instance(),
                $app['xe.db.proxy']
            );

            $proxyClass = $app['xe.interception']->proxy(DatabaseHandler::class, 'XeDB');
            return new $proxyClass(
                $coupler,
                $app['config']->get('xe.database')
            );
        });
        $this->app->alias(DatabaseHandler::class, 'xe.db');
    }
}
