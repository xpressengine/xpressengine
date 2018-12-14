<?php
/**
 * ToggleMenuServiceProvider.php
 *
 * PHP version 7
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
use Xpressengine\ToggleMenu\ToggleMenuHandler;

/**
 * Class ToggleMenuServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ToggleMenuServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('xe.toggleMenu', function ($app) {
            $proxyClass = $app['xe.interception']->proxy(ToggleMenuHandler::class, 'ToggleMenu');
            return new $proxyClass($app['xe.pluginRegister'], $app['xe.config'], $app);
        }, true);
    }
}
