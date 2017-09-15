<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use App\UIObjects\Skin\SkinSelect;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Skin\SkinInstanceStore;

class SkinServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SkinHandler::class, function ($app) {
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
        });
        $this->app->alias(SkinHandler::class, 'xe.skin');
    }

    public function boot()
    {
        $this->app['xe.pluginRegister']->add(\App\Skins\Error\DefaultErrorSkin::class);
        $this->registerSkinListUIObject();
    }

    private function registerSkinListUIObject()
    {
        /** @var \Xpressengine\Plugin\PluginRegister $registryManager */
        $registryManager = $this->app['xe.pluginRegister'];
        $registryManager->add(SkinSelect::class);
    }
}
