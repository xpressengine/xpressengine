<?php
/**
 * AppServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Foundation\Operator;

/**
 * Class AppServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
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
                if ($app['db']->connection()->getSchemaBuilder()->hasTable('user_login_log')) {
                    $app['db']->table('user_login_log')->insert([
                        'user_id' => $event->user->getAuthIdentifier(),
                        'user_agent' => $app['request']->userAgent(),
                        'ip' => $app['request']->ip(),
                        'created_at' => Carbon::now(),
                    ]);
                }
            });
        });

        $this->app->singleton(Operator::class, function () {
            return new Operator(storage_path('app/operations.json'));
        });
    }
}
