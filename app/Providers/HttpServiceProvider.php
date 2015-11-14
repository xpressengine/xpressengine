<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HttpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // if (!$this->app->runningInConsole());
        $this->app['request']->setConfig($this->app['config']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /** @var \Illuminate\Http\Request $request */
        $request = $this->app['request'];

        if (!$request instanceof \Xpressengine\Http\Request) {
            $this->app->instance('request', \Xpressengine\Http\Request::createFromBase($request));
        }
    }
}
