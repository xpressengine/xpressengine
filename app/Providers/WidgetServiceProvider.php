<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

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
        $pluginRegister = $this->app['xe.pluginRegister'];
        $pluginRegister->add(StorageSpace::class);
        $pluginRegister->add(ContentInfo::class);
        $pluginRegister->add(SystemInfo::class);
        $pluginRegister->add(HtmlWidget::class);
    }

    protected function registerUIObject()
    {
        $registryManager = $this->app['xe.pluginRegister'];
        $registryManager->add(WidgetGenerator::class);
    }
}
