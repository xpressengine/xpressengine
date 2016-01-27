<?php
/**
 * This file is tag package service provider class.
 *
 * PHP version 5
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Tag\Decomposer;
use Xpressengine\Tag\TagHandler;
use Xpressengine\Tag\TagRepository;

/**
 * laravel 에서의 사용을 위한 register
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class TagServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('xe.tag', function ($app) {
            $proxyClass = $app['xe.interception']->proxy(TagHandler::class, 'XeTag');

            return new $proxyClass(new Decomposer());
        }, true);

        $this->app->singleton(TagHandler::class, 'xe.tag');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.tag'];
    }
}
