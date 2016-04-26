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
use Xpressengine\Http\Request;
use Xpressengine\Site\Site;
use Xpressengine\Site\SiteHandler;

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
            /** @var Request $request */
            $request = app('request');
            $host = $request->getHttpHost();

            $site = Site::where('host', $host)->first();
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
            ['Xpressengine\Site\SiteHandler' => 'xe.site'],
            function ($app) {
                $config = $app['xe.config'];
                $proxyClass = $app['xe.interception']->proxy(SiteHandler::class, 'XeSite');
                return new $proxyClass($config);
            }
        );
    }
}
