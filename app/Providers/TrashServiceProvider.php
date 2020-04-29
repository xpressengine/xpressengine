<?php
/**
 * TrashServiceProvider.php
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
use Xpressengine\Trash\TrashManager;

/**
 * Class TrashServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TrashServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->hooks();
    }

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
    }

    /**
     * Add event listener.
     *
     * @return void
     */
    private function hooks()
    {
        // manage menu 등록
        intercept(
            'XeSettings@getManageMenu',
            ['trash.managemenu' => ['before' => 'manage.sort']],
            function ($target) {
                $menu          = $target();
                $menu['contents']['submenu']['trash'] = [
                    'title' => xe_trans('xe::trash').' '.xe_trans('xe::manage'),
                    'description' => '',
                    'link' => route('manage.trash.index')

                ];
                return $menu;
            }
        );
    }
}
