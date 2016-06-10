<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category    Trash
 * @package     Xpressengine\Trash
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Trash\TrashManager;

/**
 * laravel service provider
 *
 * @category    Trash
 * @package     Xpressengine\Trash
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
            'XeSettings@getManageMenu',
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
