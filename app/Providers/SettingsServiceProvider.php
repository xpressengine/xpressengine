<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Settings\SettingsHandler;
use Xpressengine\Settings\SettingsMenuPermission;
use Xpressengine\Permission\Factory as PermissionFactory;
use App\Themes\SettingsTheme;
use App\Themes\DefaultSettings;
use App\UIObjects\Settings\SettingsPermission;

class SettingsServiceProvider extends ServiceProvider
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
            'xe.settings',
            function ($app) {
                $handler = $app['xe.interception']->proxy(SettingsHandler::class, 'XeSettings');
                $handler = new $handler(
                    $app['xe.register'],
                    $app['router'],
                    $app['xe.config'],
                    $app['Illuminate\Contracts\Auth\Access\Gate']
                );

                return $handler;
            }
        );
    }

    public function boot()
    {
        $app = $this->app;

        // register default manage theme.
        $this->registerDefaultTheme();

        // register settings menus;
        $this->registerSettingsMenus();

        // register settings permission type
//        $this->registerSettingsPermissionType();
        $this->registerPermissionUIObject();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.settings'];
    }

//    private function registerSettingsPermissionType()
//    {
//        /** @var PermissionFactory $permissionFactory */
//        $permissionFactory = $this->app['xe.permission'];
//        $permissionFactory->extend(
//            'settings',
//            function ($target, $user, $registered) {
//                return new SettingsMenuPermission($user, $registered);
//            }
//        );
//    }

    private function registerPermissionUIObject()
    {
        $this->app['xe.pluginRegister']->add(SettingsPermission::class);
    }

    /**
     * rgisterDefaultTheme
     *
     * @return void
     */
    protected function registerDefaultTheme()
    {
        $this->app['xe.pluginRegister']->add(SettingsTheme::class);
        SettingsTheme::boot();
    }

    private function registerSettingsMenus()
    {
        $menus = $this->app['config']->get('xe.settings.menus');
        $register = $this->app['xe.register'];

        foreach ($menus as $id => $menu) {
            $register->push('settings/menu', $id, $menu);
        }
    }
}
