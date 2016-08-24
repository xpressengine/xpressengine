<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\User\Models\WidgetBox;
use Xpressengine\WidgetBox\WidgetBoxHandler;
use Xpressengine\WidgetBox\WidgetBoxRepository;

/**
 * Class WidgetBoxServiceProvider
 *
 * @category    WidgetBox
 * @package     App\Providers
 */
class WidgetBoxServiceProvider extends ServiceProvider
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
            [WidgetBoxRepository::class => 'xe.widgetbox'],
            function ($app) {
                $proxyClass = $app['xe.interception']->proxy(WidgetBoxHandler::class, 'XeWidgetBox');
                $widgetHandler = new $proxyClass(
                    $app['xe.widgetboxs']
                );
                return $widgetHandler;
            }
        );

        $this->app->singleton(
            [WidgetBoxRepository::class => 'xe.widgetboxs'],
            function ($app) {
                return new WidgetBoxRepository(WidgetBox::class);
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
