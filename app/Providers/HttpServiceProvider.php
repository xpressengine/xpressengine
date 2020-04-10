<?php
/**
 * HttpServiceProvider.php
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

use Illuminate\Contracts\Cookie\Factory as CookieFactory;
use Illuminate\Support\ServiceProvider;

/**
 * Class HttpServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class HttpServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // request 는 web 요청에서만 사용됨. index.php 에서 생성된 후 router 에 의해
        // dispatch 되기전에 rebound 됨. 이 시점에 request 에서 처리하기 위한 요소를 정의 함.
        $this->app->rebinding('request', function ($app, $request) {
            $config = $app['config'];
            $request->setConfig($config);

            if ($config['xe.lang.locale_type'] === 'route') {
                if (in_array($locale = $request->rawSegment(1), $config['xe.lang.locales'])) {
                    $app['url']->formatHostUsing(function ($root) use ($locale) {
                        return rtrim($root, '/') . '/' . $locale;
                    });
                    $request->enableLocaleSegment();
                } else {
                    $locale = $this->getFallbackLocale();
                }
            } elseif ($config['xe.lang.locale_type'] === 'domain') {
                $locale = array_search($request->getHttpHost(), $config['xe.lang.locale_domains']);
                if ($locale === false) {
                    $locale = $this->getFallbackLocale();
                }
            } else {
                $locale = $request->get('_l') ?: $request->cookie('locale');
                if (!in_array($locale, $config['xe.lang.locales'])) {
                    $locale = $this->getFallbackLocale();
                }
            }

            $app['cookie']->queue(
                $app[CookieFactory::class]->forever('locale', $locale, null, null, false, false)
            );

            $app->setLocale($locale);
        });
    }

    protected function getFallbackLocale()
    {
        return $this->app['xe.translator']->getLocale();
    }
}
