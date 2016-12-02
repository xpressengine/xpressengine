<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category  Providers
 * @package   App\Providers
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Presenter\Html\FrontendHandler;
use Xpressengine\Presenter\Html\HtmlPresenter;
use Xpressengine\Presenter\Json\JsonPresenter;
use Xpressengine\Presenter\Presenter;
use Xpressengine\Presenter\Redirector;
use Xpressengine\Routing\InstanceConfig;
use Xpressengine\Storage\File;

/**
 * Presenter Service Provider
 *
 * @category  Providers
 * @package   App\Providers
 */
class PresenterServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPresenter();
        $this->registerFrontend();
        $this->registerRedirector();
    }

    /**
     * boot
     *
     * @return void
     */
    public function boot()
    {
        if (app()->runningInConsole() === false && !request()->ajax()) {
            $this->app->booted(
                function () {

                    $frontendHandler = app('xe.frontend');

                    // set site title
                    $this->loadTitle($frontendHandler);

                    // load default files
                    $this->loadDefaultFiles($frontendHandler);

                    // icon
                    $this->loadIcon($frontendHandler);
                }
            );
        }

    }

    /**
     * register presenter
     *
     * @return void
     */
    private function registerPresenter()
    {
        $this->app->singleton('xe.presenter', function ($app) {

            $proxyClass = $app['xe.interception']->proxy(Presenter::class, 'Presenter');

            /** @var \Xpressengine\Presenter\Presenter $presenter */
            $presenter = new $proxyClass(
                $app['view'],
                $app['request'],
                $app['xe.theme'],
                $app['xe.skin'],
                $app['xe.settings'],
                InstanceConfig::instance()
            );

            HtmlPresenter::setCommonHtmlWrapper(app('config')['xe.HtmlWrapper.common']);
            HtmlPresenter::setPopupHtmlWrapper(app('config')['xe.HtmlWrapper.popup']);

            /** @var \Xpressengine\Presenter\Presentable $htmlProxy */
            $htmlProxy = $app['xe.interception']->proxy(HtmlPresenter::class, 'HtmlRenderer');
            /** @var \Xpressengine\Presenter\Presentable $jsonProxy */
            $jsonProxy = $app['xe.interception']->proxy(JsonPresenter::class, 'JsonRenderer');

            $presenter->register(
                $htmlProxy::format(),
                function (Presenter $presenter) use ($htmlProxy) {
                    return new $htmlProxy($presenter, app('xe.seo'), app('xe.widget.parser'));
                }
            );
            $presenter->register(
                $jsonProxy::format(),
                function (Presenter $presenter) use ($jsonProxy) {
                    return new $jsonProxy($presenter);
                }
            );

            return $presenter;
        });
    }

    /**
     * register frontend
     *
     * @return void
     */
    private function registerFrontend()
    {
        $this->app->singleton(['xe.frontend' => FrontendHandler::class], function ($app) {
            $tags = [
                'title' => \Xpressengine\Presenter\Html\Tags\Title::class,
                'meta' => \Xpressengine\Presenter\Html\Tags\Meta::class,
                'icon' => \Xpressengine\Presenter\Html\Tags\IconFile::class,
                'css' => \Xpressengine\Presenter\Html\Tags\CSSFile::class,
                'js' => \Xpressengine\Presenter\Html\Tags\JSFile::class,
                'bodyClass' => \Xpressengine\Presenter\Html\Tags\BodyClass::class,
                'html' => \Xpressengine\Presenter\Html\Tags\Html::class,
                'rule' => \Xpressengine\Presenter\Html\Tags\Rule::class,
                'translation' => \Xpressengine\Presenter\Html\Tags\Translation::class,
                'package' => \Xpressengine\Presenter\Html\Tags\Package::class
            ];

            $frontendHandler = $app['xe.interception']->proxy(FrontendHandler::class, 'XeFrontend');
            $frontendHandler = new $frontendHandler($tags);

            // inject frontend handler to Package
            \Xpressengine\Presenter\Html\Tags\Package::setHandler($frontendHandler);

            return $frontendHandler;
        });
    }

    private function registerRedirector()
    {
        $this->app->singleton('xe.redirect', function ($app) {
            $redirector = new Redirector($app['url']);

            // If the session is set on the application instance, we'll inject it into
            // the redirector instance. This allows the redirect responses to allow
            // for the quite convenient "with" methods that flash to the session.
            if (isset($app['session.store'])) {
                $redirector->setSession($app['session.store']);
            }

            return $redirector;
        });
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

    /**
     * loadDefaultFiles
     *
     * @param FrontendHandler $frontendHandler frontend handler
     * @return void
     */
    protected function loadDefaultFiles(FrontendHandler $frontendHandler)
    {
        $frontendHandler->css([
            'assets/core/common/css/xe-common.css',
            'assets/core/xe-ui-component/xe-ui-component.css', // @TODO 제거
            '//cdn.jsdelivr.net/xeicon/2.0.0/xeicon.min.css', // @TODO 제거
        ])->load();

        $frontendHandler->js([
            'assets/vendor/vendor.bundle.js',
            'assets/bundle.js',
            'assets/core/common/js/xe.bundle.js',
        ])->appendTo('head.prepend')->load();

        $frontendHandler->js('assets/core/common/js/usermenu.js')->load(); // @TODO 제거
    }

    /**
     * loadTitle
     *
     * @param FrontendHandler $frontendHandler frontend handler
     * @return void
     */
    protected function loadTitle(FrontendHandler $frontendHandler)
    {
        $siteConfig = app('xe.site')->getSiteConfig();
        $frontendHandler->title($siteConfig['site_title']);
    }

    /**
     * loadIcon
     *
     * @param FrontendHandler $frontendHandler frontend handler
     * @return void
     */
    protected function loadIcon(FrontendHandler $frontendHandler)
    {
        $siteConfig = app('xe.site')->getSiteConfig();

        $icon = $siteConfig->get('favicon.path');
        if ($icon !== null) {
                $frontendHandler->icon($icon)->load();
        }
    }

}
