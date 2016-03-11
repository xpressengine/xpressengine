<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category  Providers
 * @package   App\Providers
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Presenter\Html\FrontendHandler;
use Xpressengine\Presenter\Html\HtmlRenderer;
use Xpressengine\Presenter\Json\JsonRenderer;
use Xpressengine\Presenter\Presenter;
use Xpressengine\Routing\InstanceConfig;

/**
 * Presenter Service Provider
 *
 * @category  Providers
 * @package   App\Providers
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
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
    }

    /**
     * boot
     *
     * @return void
     */
    public function boot()
    {
        if (app()->runningInConsole() === false) {
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

            HtmlRenderer::setCommonHtmlWrapper(app('config')['xe.HtmlWrapper.common']);
            HtmlRenderer::setPopupHtmlWrapper(app('config')['xe.HtmlWrapper.popup']);

            /** @var \Xpressengine\Presenter\RendererInterface $proxyHtmlRenderer */
            $proxyHtmlRenderer = $app['xe.interception']->proxy(HtmlRenderer::class, 'HtmlRenderer');
            /** @var \Xpressengine\Presenter\RendererInterface $proxyJsonRenderer */
            $proxyJsonRenderer = $app['xe.interception']->proxy(JsonRenderer::class, 'JsonRenderer');

            $presenter->register(
                $proxyHtmlRenderer::format(),
                function (Presenter $presenter) use ($proxyHtmlRenderer) {
                    return new $proxyHtmlRenderer($presenter, app('xe.seo'), app('xe.widget.parser'));
                }
            );
            $presenter->register(
                $proxyJsonRenderer::format(),
                function (Presenter $presenter) use ($proxyJsonRenderer) {
                    return new $proxyJsonRenderer($presenter);
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
        $this->app->singleton('xe.frontend', function ($app) {
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
        $frontendHandler->js('assets/vendor/jquery/jquery.js')
            ->min('assets/vendor/jquery/jquery.min.js')->appendTo('head')->load();
        $frontendHandler->js('assets/vendor/bootstrap/js/bootstrap.js')
            ->min('assets/vendor/bootstrap/js/bootstrap.min.js')->appendTo('head')->load();
        $frontendHandler->js(
            [
                'assets/vendor/jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
                'assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js',
                'assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js',
                'assets/vendor/react/react-with-addons.js',
                'assets/vendor/react/JSXTransformer.js',
                'assets/vendor/core/js/translator.js',
                'assets/vendor/core/js/xe.js',
                'assets/vendor/core/js/helpers.js',
                'assets/vendor/core/js/toggleMenu.js',
            ]
        )->appendTo('head')->load();


        $frontendHandler->css([
            'assets/common/css/normalize.css',
            'assets/vendor/core/css/xe.css',
            'assets/common/css/alert.css',
            '//cdn.jsdelivr.net/xeicon/2.0.0/xeicon.min.css',
        ])->before('assets/vendor/bootstrap/css/bootstrap.css')->load();
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

        if ($siteConfig['favicon'] !== null) {
            $iconFile = $this->app->make('xe.storage')->get($siteConfig['favicon']);
            if ($iconFile !== null) {
                $iconUrl = $this->app->make('xe.media')->make($iconFile)->url();
                $frontendHandler->icon($iconUrl)->load();
            }
        }
    }

}
