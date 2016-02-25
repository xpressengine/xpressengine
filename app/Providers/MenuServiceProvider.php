<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Menu\DBMenuRepository;
use Xpressengine\Menu\MenuAlterHandler;
use Xpressengine\Menu\MenuCacheHandler;
use Xpressengine\Menu\MenuConfigHandler;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Menu\MenuItemPolicy;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Menu\MenuPermissionHandler;
use Xpressengine\Menu\MenuRetrieveHandler;
use Xpressengine\UIObjects\Menu\MenuList;
use Xpressengine\UIObjects\Menu\MenuType;
use Xpressengine\UIObjects\Menu\MenuThemeList;
use Xpressengine\UIObjects\Menu\MenuSelector;
use Xpressengine\Menu\MenuType\DirectLink;
use Xpressengine\UIObjects\Menu\TypeSelect;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * Menu Service Provider
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuServiceProvider extends ServiceProvider
{
    protected $policies = [
        MenuItem::class => MenuItemPolicy::class
    ];

    /**
     * Service Provider Boot
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $pluginRegister = $this->app['xe.pluginRegister'];

        $pluginRegister->add(MenuList::class);
        $pluginRegister->add(MenuType::class);
        $pluginRegister->add(TypeSelect::class);
        $pluginRegister->add(MenuSelector::class);
        $pluginRegister->add(MenuThemeList::class);
        $pluginRegister->add(DirectLink::class);

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
//        $this->app->singleton(
//            'xe.menu.cache',
//            function ($app) {
//                $cache = $app['cache'];
//                $debugMode = env('APP_DEBUG', false);
//
//                return new MenuCacheHandler($cache, $debugMode);
//            }
//        );
//
//        $this->app->singleton(
//            'xe.menu.permission',
//            function ($app) {
//                $permission = $app['xe.permission'];
//                $groups = $app['xe.member.groups'];
//                $members = $app['xe.members'];
//                return new MenuPermissionHandler($permission, $groups, $members);
//            }
//        );
//
//        $this->app->singleton(
//            'xe.menu',
//            function ($app) {
//                $conn = $app['xe.db']->connection();
//                $keygen = $app['xe.keygen'];
//                $type = $app['xe.module'];
//                $cacheHandler = $app['xe.menu.cache'];
//                $proxyClass = $app['xe.interception']->proxy(MenuRetrieveHandler::class, 'Menu');
//                return new $proxyClass(new DBMenuRepository($conn, $keygen), $type, $cacheHandler);
//            }
//        );
//
//        $this->app->singleton(
//            'xe.menu.changer',
//            function ($app) {
//                $conn = $app['xe.db']->connection();
//                $keygen = $app['xe.keygen'];
//                $type = $app['xe.module'];
//                $router = $app['xe.router'];
//                $cacheHandler = $app['xe.menu.cache'];
//                return new MenuAlterHandler(new DBMenuRepository($conn, $keygen), $type, $router, $cacheHandler);
//
//            }
//        );
//
//        $this->app->singleton(
//            'xe.menu.config',
//            function ($app) {
//                $config = $app['xe.config'];
//                $theme = $app['xe.theme'];
//                return new MenuConfigHandler($config, $theme);
//            }
//        );
//
//        $this->app->bind(
//            'Xpressengine\Menu\MenuRetrieveHandler',
//            'xe.menu'
//        );
//
//        $this->app->bind(
//            'Xpressengine\Menu\MenuAlterHandler',
//            'xe.menu.changer'
//        );
//
//        $this->app->bind(
//            'Xpressengine\Menu\MenuConfigHandler',
//            'xe.menu.config'
//        );
//
//        $this->app->bind(
//            'Xpressengine\Menu\MenuCacheHandler',
//            'xe.menu.cache'
//        );
//
//        $this->app->bind(
//            'Xpressengine\Menu\MenuPermissionHandler',
//            'xe.menu.permission'
//        );

        $this->app->singleton([MenuHandler::class => 'xe.menu'], function ($app) {
            return new MenuHandler(
                $app['xe.keygen'],
                $app['xe.config'],
                $app['xe.permission']
            );
        });
    }
}
