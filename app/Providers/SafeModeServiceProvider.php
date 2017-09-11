<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Route;

class SafeModeServiceProvider extends ServiceProvider
{

    /**
     * Service Provider Boot
     *
     * @return void
     */
    public function boot()
    {
        app('config')->set('app.debug', true);

        app('config')->set('auth.driver', 'database');
        app('config')->set('auth.table', 'user');
        app('config')->set('auth.model', \XpressEngine\User\Models\User::class);

        require_once($this->app->basePath() . '/app/Http/safe_mode_routes.php');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}
