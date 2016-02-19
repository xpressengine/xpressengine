<?php
/**
 * Class PermissionServiceProvider
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Permission\PermissionRepository;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\UIObjects\Permission\Permission as PermissionUIObject;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Xpressengine\Permission\Instance;
use Xpressengine\Permission\InstancePolicy;

/**
 * laravel 에서의 구동을 위해 현재 패키지를 등록
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PermissionServiceProvider extends ServiceProvider
{
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
        $this->app->singleton([PermissionHandler::class => 'xe.permission'], function ($app) {
            return new PermissionHandler(new PermissionRepository($app['xe.db']->connection()));
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
