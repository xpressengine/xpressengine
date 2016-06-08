<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     LGPL-2.1 http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Widget\WidgetHandler;
use Xpressengine\Widget\WidgetParser;
use Xpressengine\Widgets\ContentInfo;
use Xpressengine\Widgets\StorageSpace;
use Xpressengine\Widgets\SystemInfo;

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
            'xe.widget',
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
            'xe.widget.parser',
            function ($app) {
                $handler = $app['xe.widget'];
                return new WidgetParser($handler);
            }
        );

        $this->app->bind(
            'Xpressengine\Widget\WidgetHandler',
            'xe.widget'
        );

        $this->app->bind(
            'Xpressengine\Widget\WidgetParser',
            'xe.widget.parser'
        );

        //intercept(
        //    'HtmlRenderer@render',
        //    'widget.replace',
        //    function ($target) {
        //        $htmlResponseString = $target();
        //
        //        /**
        //         * @var WidgetParser $parser
        //         */
        //        $parser = app('xe.widget.parser');
        //
        //        $htmlResponseString = $parser->parseXml($htmlResponseString);
        //        return $htmlResponseString;
        //    }
        //);
    }

    /**
     * boot
     *
     * @return void
     */
    public function boot()
    {
        $pluginRegister = $this->app['xe.pluginRegister'];
        $pluginRegister->add(StorageSpace::class);
        $pluginRegister->add(ContentInfo::class);
        $pluginRegister->add(SystemInfo::class);
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
}
