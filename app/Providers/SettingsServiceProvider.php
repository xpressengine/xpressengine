<?php
/**
 * SettingsServiceProvider.php
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

use App\Themes\DefaultSettings;
use App\Themes\SettingsTheme;
use App\UIObjects\Settings\SettingsPermission;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Log\Loggers\UserLogger;
use Xpressengine\Log\LogHandler;
use Xpressengine\Register\Container;
use Xpressengine\Settings\SettingsHandler;
use Xpressengine\Settings\SettingsMenuPermission;

/**
 * Class SettingsServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
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
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // register default manage theme.
        $this->registerDefaultTheme();

        // register settings menus;
        $this->registerSettingsMenus();

        // register settings permission uiobject
        $this->registerPermissionUIObject();

        $this->registerLoggers();
    }

    /**
     * Register the ui object of the permission.
     *
     * @return void
     */
    private function registerPermissionUIObject()
    {
        $this->app['xe.pluginRegister']->add(SettingsPermission::class);
    }

    /**
     * Register the default theme.
     *
     * @return void
     */
    protected function registerDefaultTheme()
    {
        $this->app['xe.pluginRegister']->add(SettingsTheme::class);
        SettingsTheme::boot();
    }

    /**
     * Register the setting menus.
     *
     * @return void
     */
    private function registerSettingsMenus()
    {
        $menus = $this->app['config']->get('xe.settings.menus');
        $register = $this->app['xe.register'];

        foreach ($menus as $id => $menu) {
            $register->push('settings/menu', $id, $menu);
        }
    }

    /**
     * Register the logger.
     *
     * @return void
     */
    private function registerLoggers()
    {
        /** @var Container $register */
        $register = $this->app['xe.register'];
        $register->push(LogHandler::ADMIN_LOGGER_KEY, UserLogger::ID, UserLogger::class);
    }
}
