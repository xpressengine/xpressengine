<?php
/**
 * PresenterServiceProvider.php
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
use Xpressengine\Media\Models\Image;
use Xpressengine\Presenter\Html\FrontendHandler;
use Xpressengine\Presenter\Html\HtmlPresenter;
use Xpressengine\Presenter\Json\JsonPresenter;
use Xpressengine\Presenter\Presenter;
use Xpressengine\Presenter\Redirector;
use Xpressengine\Routing\InstanceConfig;

/**
 * Class PresenterServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->runningInConsole() === false && !request()->ajax()) {
            intercept('Presenter@make' , 'frontend.load.default', function ($method, $id, array $data = [], array $mergeData = [], $html = true, $api = false) {
                $frontendHandler = app('xe.frontend');
                // set site title
                $this->loadTitle($frontendHandler);
                // load default files
                $this->loadDefaultFiles($frontendHandler);
                // icon
                $this->loadIcon($frontendHandler);

                return $method($id, $data, $mergeData, $html, $api);
            });
        }
    }

    /**
     * Register the presenter
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
     * Register the frontend handler
     *
     * @return void
     */
    private function registerFrontend()
    {
        $this->app->singleton(FrontendHandler::class, function ($app) {
            $tags = [
                'title' => \Xpressengine\Presenter\Html\Tags\Title::class,
                'meta' => \Xpressengine\Presenter\Html\Tags\Meta::class,
                'icon' => \Xpressengine\Presenter\Html\Tags\IconFile::class,
                'css' => \Xpressengine\Presenter\Html\Tags\CSSFile::class,
                'js' => \Xpressengine\Presenter\Html\Tags\JSFile::class,
                'bodyClass' => \Xpressengine\Presenter\Html\Tags\BodyClass::class,
                'html' => \Xpressengine\Presenter\Html\Tags\Html::class,
                'route' => \Xpressengine\Presenter\Html\Tags\Route::class,
                'rule' => \Xpressengine\Presenter\Html\Tags\Rule::class,
                'translation' => \Xpressengine\Presenter\Html\Tags\Translation::class,
                'preload' => \Xpressengine\Presenter\Html\Tags\Preload::class
            ];

            $frontendHandler = $app['xe.interception']->proxy(FrontendHandler::class, 'XeFrontend');
            $frontendHandler = new $frontendHandler($tags);

            return $frontendHandler;
        });
        $this->app->alias(FrontendHandler::class, 'xe.frontend');
    }

    /**
     * Register the redirector.
     *
     * @return void
     */
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
     * Load default assets.
     *
     * @param FrontendHandler $frontendHandler frontend handler
     * @return void
     */
    protected function loadDefaultFiles(FrontendHandler $frontendHandler)
    {
        $frontendHandler->css([
            'assets/core/common/css/xe-common.css',
            'assets/core/xe-ui-component/xe-ui-component.css', // @TODO 제거
            'https://cdn.jsdelivr.net/npm/xeicon@2.3/xeicon.min.css', // @TODO 제거
        ])->load();

        $frontendHandler->js([
            'assets/vendor.js',
            'assets/common.js',
            'assets/core/common/js/xe.bundle.js',
        ])->prependTo('head')->load();
    }

    /**
     * Load the title for the application.
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
     * Load the icon for the application.
     *
     * @param FrontendHandler $frontendHandler frontend handler
     * @return void
     */
    protected function loadIcon(FrontendHandler $frontendHandler)
    {
        $siteConfig = app('xe.site')->getSiteConfig();
        $imageId = $siteConfig->get('favicon.id');
        if ($imageId) {
            $image = Image::find($imageId);
            if (!is_null($image)) {
                $icon = $image->url();
                $frontendHandler->icon($icon)->load();
            }
        }
    }
}
