<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     LGPL-2.1 http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Skin\SkinInstanceStore;

class SkinServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'xe.skin',
            function ($app) {
                $skinInstanceStore = new SkinInstanceStore($app['xe.config']);
                $defaultSkins = $app['config']->get('xe.skin.defaultSkins');
                $defaultSettingsSkins = $app['config']->get('xe.skin.defaultSettingsSkins');
                $skinHandler = $app['xe.interception']->proxy(SkinHandler::class, 'XeSkin');
                $skinHandler = new $skinHandler(
                    $app['xe.pluginRegister'],
                    $skinInstanceStore,
                    $defaultSkins,
                    $defaultSettingsSkins
                );
                return $skinHandler;
            }
        );
        $this->app->bind(SkinHandler::class, 'xe.skin');
    }

    public function boot()
    {
        $this->app['xe.pluginRegister']->add(\Xpressengine\Skins\Error\DefaultErrorSkin::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
