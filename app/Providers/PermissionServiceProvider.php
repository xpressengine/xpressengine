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
use Xpressengine\Permission\Factory;
use Xpressengine\Permission\PermissionRepository;
use Xpressengine\Permission\Permissions\AbstractRegisteredPermission;
use Xpressengine\UIObjects\Permission\Permission as PermissionUIObject;

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
    public function boot()
    {
        $this->app['xe.pluginRegister']->add(PermissionUIObject::class);

        AbstractRegisteredPermission::setVirtualGroupRepository($this->app['xe.member.virtualGroups']);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('xe.permission', function ($app) {
            $proxyClass = $app['xe.interception']->proxy(Factory::class, 'Permission');
            return new $proxyClass(
                $app['auth'],
                $app['router']->getRoutes(),
                new PermissionRepository($app['xe.db']->connection())
            );
        }, true);

        $this->app->bind(
            'Xpressengine\Permission\Factory',
            'xe.permission'
        );
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
