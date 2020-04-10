<?php
/**
 * SiteServiceProvider.php
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
use Xpressengine\Http\Request;
use Xpressengine\Site\Site;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Site\SiteRepository;

/**
 * Class SiteServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
        $site = $site ?: $this->app['xe.site']->findBy('site_key', 'default');
        $this->app['xe.site']->setCurrentSite($site);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SiteHandler::class, function ($app) {
            $proxyClass = $app['xe.interception']->proxy(SiteHandler::class, 'XeSite');
            return new $proxyClass(new SiteRepository(), $app['xe.config']);
        });
        $this->app->alias(SiteHandler::class, 'xe.site');
    }
}
