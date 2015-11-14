<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category  Site
 * @package   Xpressengine\Site
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Site\SiteRepository;

/**
 * Site Service Provider
 *
 * @category Site
 * @package  Xpressengine\Site
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class SiteServiceProvider extends ServiceProvider
{

    /**
     * Service Provider Boot
     *
     * @return void
     */
    public function boot()
    {
        if (app()->runningInConsole() === false) {
            $request = app('request');
            $host = $request->getHost();

            $site = app('xe.site')->get($host);
            app('xe.site')->setCurrentSite($site);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'xe.site',
            function ($app) {
                $conn = $app['xe.db']->connection();
                $config = $app['xe.config'];
                $proxyClass = $app['xe.interception']->proxy(SiteHandler::class, 'site');
                return new $proxyClass(new SiteRepository($conn), $config);
            }
        );

        $this->app->bind(
            'Xpressengine\Site\SiteHandler',
            'xe.site'
        );
    }
}
