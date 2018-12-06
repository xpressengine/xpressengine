<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\Support\Exceptions\AccessDeniedHttpException;
use Xpressengine\Theme\AbstractTheme;
use Xpressengine\Theme\ThemeHandler;
use App\UIObjects\Theme\ThemeSelect;

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

            return $themeHandler;
        });
        $this->app->alias(ThemeHandler::class, 'xe.theme');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // TODO: move code to valid location!!!
        // TODO: check permission!!
        $this->registerInterceptForThemePreview();

        $this->registerBlankTheme();

        $this->registerThemeListUIObject();

        $this->registerMobileResolver();

        $this->setThemeHandlerForTheme();

    }

    /**
     * Add event listener for preview theme.
     *
     * @return void
     */
    protected function registerInterceptForThemePreview()
    {
        $preview_theme = $this->app['request']->get('preview_theme', null);
        if ($preview_theme !== null) {
            intercept(
                'XeTheme@getSelectedTheme',
                'preview_theme',
                function ($target) use ($preview_theme) {
                    if (!auth()->user()->isAdmin()) {
                        throw new AccessDeniedHttpException();
                    }

                    /** @var ThemeHandler $themeHandler */
                    $themeHandler = $target->getTargetObject();
                    $themeHandler->selectTheme($preview_theme);
                    return $target();
                }
            );
        }
    }

    /**
     * Register the blank theme.
     *
     * @return void
     */
    protected function registerBlankTheme()
    {
        /** @var PluginRegister $registryManager */
        $registryManager = $this->app['xe.pluginRegister'];
        $blankThemeClass = $this->app['config']->get('xe.theme.blank');
        $registryManager->add($blankThemeClass);
    }

    /**
     * Register the ui object of theme selector.
     *
     * @return void
     */
    private function registerThemeListUIObject()
    {
        /** @var PluginRegister $registryManager */
        $registryManager = $this->app['xe.pluginRegister'];
        $registryManager->add(ThemeSelect::class);
    }

    /**
     * Register the mobile detector.
     *
     * @return void
     */
    private function registerMobileResolver()
    {
        $this->app['xe.theme']->setMobileResolver(function(){
            return app('request')->isMobile();
        });
    }

    /**
     * Set handler to the theme.
     *
     * @return void
     */
    private function setThemeHandlerForTheme()
    {
        AbstractTheme::setHandler($this->app->make('xe.theme'));
    }
}
