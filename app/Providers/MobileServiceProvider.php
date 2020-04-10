<?php
/**
 * MobileServiceProvider.php
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

use Blade;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;

/**
 * Class MobileServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MobileServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->extendBlade();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRequestRebindHandler();
    }

    /**
     * Register a resolver for the authenticated user.
     *
     * @return void
     */
    protected function registerRequestRebindHandler()
    {
        $this->app->rebinding(
            'request',
            function ($app, $request) {
                $request->setMobileResolver($this->getMobileResolver());
            }
        );
    }

    /**
     * Add the directive for blade template.
     *
     * @return void
     */
    protected function extendBlade()
    {
        Blade::directive(
            'mobileonly',
            function ($expression) {
                return "<?php if(app('request')->isMobile()) { ?>";
            }
        );
        Blade::directive(
            'endmobileonly',
            function ($expression) {
                return "<?php } ?>";
            }
        );
        Blade::directive(
            'desktoponly',
            function ($expression) {
                return "<?php if(!app('request')->isMobile()) { ?>";
            }
        );
        Blade::directive(
            'enddesktoponly',
            function ($expression) {
                return "<?php } ?>";
            }
        );
    }

    /**
     * Get the resolver for detect mobile device.
     *
     * @return \Closure
     */
    protected function getMobileResolver()
    {
        return function (Request $request, $byUserAgent = false) {
            $app = $this->app;
            if ($byUserAgent === false) {
                $isMobile = $request->get('_m', null);
                if ($isMobile === '1') {
                    $isMobile = true;
                } elseif ($isMobile === '0') {
                    $isMobile = false;
                }

                /** @var CookieJar $cookie */
                $cookie = $app['cookie'];

                // determine isMobile by query string
                if ($isMobile === true) {
                    $cookie->queue('mobile', '1', 120);
                    return $isMobile;
                } elseif ($isMobile === false) {
                    $cookie->queue('mobile', '0', 120);
                    return $isMobile;
                }

                // determine isMobile by cookie
                $isMobile = $request->cookie('mobile', null);
                if ($isMobile !== null) {
                    return $isMobile === '1';
                }
            }

            // determine isMobile by user-agent
            /** @var Agent $agent */
            $agent = $app['agent'];
            if ($agent->isMobile() || $agent->isTablet()) {
                return true;
            } else {
                return false;
            }
        };
    }
}
