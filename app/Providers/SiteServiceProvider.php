<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category  Site
 * @package   Xpressengine\Site
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Http\Request;
use Xpressengine\Site\Site;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Site\SiteRepository;

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
        SiteRepository::setModel(Site::class);

        $site = null;
        if ($this->app->runningInConsole() === false) {
            /** @var Request $request */
            $request = $this->app['request'];
            $host = $request->getHttpHost();
            $host = $host.str_replace('/index.php','',$request->server('SCRIPT_NAME'));
            $site = $this->app['xe.site']->findBy('host', $host);
        }
        $site = $site ?: $this->app['xe.site']->findBy('siteKey', 'default');
        $this->app['xe.site']->setCurrentSite($site);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            ['xe.site' => SiteHandler::class],
            function ($app) {
                $proxyClass = $app['xe.interception']->proxy(SiteHandler::class, 'XeSite');
                return new $proxyClass(new SiteRepository(), $app['xe.config']);
            }
        );
    }
}
