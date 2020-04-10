<?php
/**
 * ConfigServiceProvider.php
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
use Xpressengine\Config\ConfigManager;
use Xpressengine\Config\Repositories\DatabaseRepository;
use Xpressengine\Config\Repositories\CacheDecorator;

/**
 * Class ConfigServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ConfigManager::class, function ($app) {
            $repo = new DatabaseRepository($app['xe.db']->connection());
            
            if ($app['config']['app.debug'] !== true) {
                $repo = new CacheDecorator(
                    $repo,
                    $app['cache.store']
                );
            }

            $proxyClass = $app['xe.interception']->proxy(ConfigManager::class, 'XeConfig');
            $configManager = new $proxyClass($repo);
            return $configManager;
        });
        $this->app->alias(ConfigManager::class, 'xe.config');
    }
}
