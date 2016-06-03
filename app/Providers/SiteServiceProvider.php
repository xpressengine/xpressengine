<?php
/**
 * Service provider
 *
 * @category  Site
 * @package   Xpressengine\Site
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
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

            $host = $host.str_replace('/index.php','',$request->server('SCRIPT_NAME'));

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
