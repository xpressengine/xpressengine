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
        $this->app['request']->setConfig($this->app['config']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // bind Request
        $this->app->bind(\Xpressengine\Http\Request::class, 'request');

        // set config to request when rebind request
        $this->app->rebinding(
            'request',
            function ($app, $request) {
                return $request->setConfig($app['config']);
            }
        );
    }
}
