<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Interception\AdvisorCollection;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Interception\Proxy\Loader\EvalLoader;
use Xpressengine\Interception\Proxy\Loader\FileLoader;
use Xpressengine\Interception\Proxy\Pass\ClassPass;
use Xpressengine\Interception\Proxy\Pass\MethodDefinitionPass;
use Xpressengine\Interception\Proxy\ProxyGenerator;

class InterceptionServiceProvider extends ServiceProvider
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
            ['xe.interception' => InterceptionHandler::class],
            function ($app) {
                $advisorCollection = new AdvisorCollection();

                $loader = new FileLoader(storage_path('app/interception'), $app['config']->get('app.debug') === true);
                //$loader = new EvalLoader();
                $passes = [new ClassPass(), new MethodDefinitionPass()];

                $generator = new ProxyGenerator($loader, $passes);

                if($app->runningInConsole()) {
                    $generator->clear();
                }

                $interceptionHandler = new InterceptionHandler($advisorCollection, $generator);
                return $interceptionHandler;
            }
        );
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
