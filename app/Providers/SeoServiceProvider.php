<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Seo\Importers\TwitterCardImporter;
use Xpressengine\Seo\SeoHandler;
use Xpressengine\Seo\Setting;
use Xpressengine\Seo\Importers\BasicImporter;
use Xpressengine\Seo\Importers\OpenGraphImporter;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('xe.seo', function ($app) {
            $setting = new Setting($app['xe.config'], $app['xe.storage'], $app['xe.media'], $app['xe.keygen']);
            return new SeoHandler(
                [
                    new BasicImporter($app['xe.frontend'], $app['request']),
                    new OpenGraphImporter($app['xe.frontend'], $app['request']),
                    new TwitterCardImporter($app['xe.frontend'], $app['request'], $setting->get('twitterUsername')),
                ],
                $setting,
                $app['xe.translator']
            );
        }, true);

        $this->app->bind(SeoHandler::class, 'xe.seo');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.seo'];
    }
}
