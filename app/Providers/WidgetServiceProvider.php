<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use App\Skins\Widget\ContentInfoSkin;
use App\Skins\Widget\HtmlWidgetSkin;
use App\Skins\Widget\StorageSpaceSkin;
use App\Skins\Widget\SystemInfoSkin;
use App\UIObjects\Widget\WidgetGenerator;
use App\Widgets\ContentInfo;
use App\Widgets\HtmlWidget;
use App\Widgets\StorageSpace;
use App\Widgets\SystemInfo;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Widget\WidgetHandler;
use Xpressengine\Widget\WidgetParser;

/**
 * Class WidgetServiceProvider
 *
 * @category    Widget
 * @package     App\Providers
 */
class WidgetServiceProvider extends ServiceProvider
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
            ['xe.widget' => WidgetHandler::class],
            function ($app) {

                $proxyClass = $app['xe.interception']->proxy(WidgetHandler::class, 'XeWidget');
                $widgetHandler = new $proxyClass(
                    $app['xe.pluginRegister'],
                    $app['xe.auth'],
                    $app['view'],
                    $app['config']->get('app.debug') === true
                );

                return $widgetHandler;
            }
        );

        $this->app->singleton(
            ['xe.widget.parser' => WidgetParser::class],
            function ($app) {
                $handler = $app['xe.widget'];
                return new WidgetParser($handler);
            }
        );
    }

    /**
     * boot
     *
     * @return void
     */
    public function boot()
    {
        $this->registerWidgets();
        $this->registerWidgetSkins();
        $this->registerUIObject();
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
     * registerWidgets
     *
     * @return void
     */
    protected function registerWidgets()
    {
        $register = $this->app['xe.pluginRegister'];
        $register->add(StorageSpace::class);
        $register->add(ContentInfo::class);
        $register->add(SystemInfo::class);
        $register->add(HtmlWidget::class);
    }

    protected function registerWidgetSkins()
    {
        $register = $this->app['xe.pluginRegister'];
        $register->add(SystemInfoSkin::class);
        $register->add(ContentInfoSkin::class);
        $register->add(StorageSpaceSkin::class);
        $register->add(HtmlWidgetSkin::class);
    }

    protected function registerUIObject()
    {
        $registryManager = $this->app['xe.pluginRegister'];
        $registryManager->add(WidgetGenerator::class);
    }
}
