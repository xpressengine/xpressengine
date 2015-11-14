<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category    Trash
 * @package     Xpressengine\Trash
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Trash\TrashManager;

/**
 * laravel service provider
 *
 * @category    Trash
 * @package     Xpressengine\Trash
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class TrashServiceProvider extends ServiceProvider
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
        $this->app->singleton(
            'xe.trash',
            function ($app) {
                $proxyClass = $app['xe.interception']->proxy(TrashManager::class, 'Trash');
                return new $proxyClass($app['xe.register'], $app['xe.db']->connection());
            }
        );

//        /**
//         * register command
//         */
//        $this->commands([
//            Commands\Trash::class,
//        ]);

        // manage menu 등록
        intercept(
            'Settings@getManageMenu',
            ['trash.managemenu' => ['before' => 'manage.sort']],
            function ($target) {
                $menu          = $target();
                $menu['contents']['submenu']['trash'] = [
                    'title' => '휴지통 관리',
                    'description' => 'blur blur~',
                    'link' => route('manage.trash.index')

                ];
                return $menu;
            }
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
