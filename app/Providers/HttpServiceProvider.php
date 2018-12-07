<?php
/**
 * HttpServiceProvider.php
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

/**
 * Class HttpServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class HttpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['request']->setConfig($this->app['config']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // bind Request
        $this->app->bind(\Xpressengine\Http\Request::class, 'request');

        // set config to request when rebind request
        $this->app->rebinding(
            'request',
            function ($app, $request) {
                return $request->setConfig($app['config']);
            }
        );
    }
}
