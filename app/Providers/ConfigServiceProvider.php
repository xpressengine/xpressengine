<?php
/**
 * Config service provider class
 *
 * PHP version 5
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Config\Repositories\DatabaseRepository;
use Xpressengine\Config\Repositories\CacheDecorator;

/**
 * laravel 에서 사용을 위해 패키지를 등록하는 역할을 하는 클래스
 *
 * @category    Config
 * @package     Xpressengine\Config
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
