<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving('auth', function ($auth, $app) {
            $app['events']->listen(Login::class, function ($event) use ($app) {
                $app['db']->table('user_login_log')->insert([
                    'user_id' => $event->user->getAuthIdentifier(),
                    'user_agent' => $app['request']->userAgent(),
                    'ip' => $app['request']->ip(),
                    'created_at' => Carbon::now(),
                ]);
            });
        });
    }
}
