<?php
/**
 * ThemeServiceProvider.php
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
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\Theme\AbstractTheme;
use Xpressengine\Theme\ThemeHandler;
use App\UIObjects\Theme\ThemeSelect;

/**
 * Class ThemeServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ThemeHandler::class, function ($app) {
            /** @var PluginRegister $register */
            $register = $app['xe.pluginRegister'];

            $themeHandler = $app['xe.interception']->proxy(ThemeHandler::class, 'XeTheme');

            $blankThemeClass = $app['config']->get('xe.theme.blank');

            /** @var ThemeHandler $themeHandler */
            $themeHandler = new $themeHandler($register, $app['xe.config'], $app['view'], $blankThemeClass::getId());
            $themeHandler->setCachePath(storage_path('app/theme/views'));
            $themeHandler->setMobileResolver(function () use ($app) {
                return $app['request']->isMobile();
            });

            AbstractTheme::setHandler($themeHandler);

            return $themeHandler;
        });
        $this->app->alias(ThemeHandler::class, 'xe.theme');

        $this->app->resolving('xe.pluginRegister', function ($register, $app) {
            $register->add($app['config']['xe.theme.blank']);
            $register->add(ThemeSelect::class);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // TODO: check permission!!
//        $this->registerInterceptForThemePreview();
    }

//    /**
//     * Add event listener for preview theme.
//     *
//     * @return void
//     */
//    protected function registerInterceptForThemePreview()
//    {
//        if ($this->app['request']->isManageRequest() === false && file_exists(app_storage_path('theme_preview.json'))) {
//            $previewInformation = json_dec(file_get_contents(app_storage_path('theme_preview.json')));
//
//            $themeConfigId = $previewInformation->configId;
//            $userId = $previewInformation->userId;
//
//            if ($themeConfigId !== null) {
//                intercept(
//                    'XeTheme@getSelectedTheme',
//                    'preview_theme',
//                    function ($target) use ($themeConfigId, $userId) {
//                        $user = auth()->user();
//                        if (!$user->isAdmin() || $user->getId() != $userId) {
//                            return $target();
//                        }
//
//                        /** @var ThemeHandler $themeHandler */
//                        $themeHandler = $target->getTargetObject();
//                        $themeHandler->selectTheme($themeConfigId);
//                        return $target();
//                    }
//                );
//            }
//        }
//    }
}
