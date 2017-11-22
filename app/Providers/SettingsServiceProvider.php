<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use App\Themes\DefaultSettings;
use App\Themes\SettingsTheme;
use App\UIObjects\Settings\SettingsPermission;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Register\Container;
use Xpressengine\Settings\AdminLog\Loggers\AuthLogger;
use Xpressengine\Settings\AdminLog\Loggers\UserLogger;
use Xpressengine\Settings\AdminLog\LogHandler;
use Xpressengine\Settings\AdminLog\Models\Log;
use Xpressengine\Settings\AdminLog\Repositories\LogRepository;
use Xpressengine\Settings\SettingsHandler;
use Xpressengine\Settings\SettingsMenuPermission;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('xe.settings', function ($app) {
            $handler = $app['xe.interception']->proxy(SettingsHandler::class, 'XeSettings');
            $handler = new $handler(
                $app['xe.register'],
                $app['router'],
                $app['xe.config'],
                $app['Illuminate\Contracts\Auth\Access\Gate']
            );

            return $handler;
        });

        // register for admin log
        $this->app->singleton('xe.adminlogs', function ($app) {
            $repo = $app['xe.interception']->proxy(LogRepository::class);
            $repo = new $repo(Log::class);
            return $repo;
        });

        $this->app->singleton(LogHandler::class, function ($app) {
            $handler = $app['xe.interception']->proxy(LogHandler::class, 'XeAdminLog');
            $handler = new $handler($app['xe.register'], $app['xe.adminlogs']);
            return $handler;
        });
        $this->app->alias(LogHandler::class, 'xe.adminlog');
    }

    public function boot()
    {
        // register default manage theme.
        $this->registerDefaultTheme();

        // register settings menus;
        $this->registerSettingsMenus();

        // register settings permission uiobject
        $this->registerPermissionUIObject();

        $this->registerDefaultLoggers();

        $this->setDetailResolverForLog();
    }

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

    private function registerDefaultLoggers()
    {
        /** @var Container $register */
        $register = $this->app['xe.register'];
        $register->push('admin/logger', UserLogger::ID, UserLogger::class);
        $register->push('admin/logger', AuthLogger::ID, AuthLogger::class);
    }

    private function setDetailResolverForLog()
    {
        /** @var LogHandler $handler */
        $handler = $this->app['xe.adminlog'];
        Log::setDetailResolver(
            function ($log) use ($handler) {
                $logger = $handler->getLogger($log->type);
                return $logger->renderDetail($log);
            }
        );
    }
}
