<?php
/**
 * DatabaseServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Xpressengine\Database\DatabaseHandler;
use Xpressengine\Database\ProxyManager;
use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Database\VirtualConnection;

/**
 * Class DatabaseServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
                    if ($binding instanceof \DateTimeInterface) {
                        $binding = new Carbon(
                            $binding->format('Y-m-d H:i:s.u'), $binding->getTimezone()
                        );
                    }
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
            $proxyClass = $app['xe.interception']->proxy(DatabaseHandler::class, 'XeDB');

            return new $proxyClass($app['db'], $app['xe.db.proxy']);
        });
        $this->app->alias(DatabaseHandler::class, 'xe.db');
    }
}
