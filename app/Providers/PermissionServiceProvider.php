<?php
/**
 * PermissionServiceProvider.php
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

use Illuminate\Support\ServiceProvider;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\Permission\Repositories\CacheDecorator;
use Xpressengine\Permission\Repositories\DatabaseRepository;
use App\UIObjects\Permission\Permission as PermissionUIObject;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Xpressengine\Permission\Instance;
use Xpressengine\Permission\InstancePolicy;

/**
 * Class PermissionServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Instance::class => InstancePolicy::class
    ];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Service Provider Boot
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->app['xe.pluginRegister']->add(PermissionUIObject::class);

        foreach ($this->policies as $class => $policy) {
            $gate->policy($class, $policy);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PermissionHandler::class, function ($app) {
            $repo = new DatabaseRepository($app['xe.db']->connection());

            if ($app['config']['app.debug'] !== true) {
                $repo = new CacheDecorator($repo, $app['cache.store']);
            }

            return new PermissionHandler($repo);
        });
        $this->app->alias(PermissionHandler::class, 'xe.permission');
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
