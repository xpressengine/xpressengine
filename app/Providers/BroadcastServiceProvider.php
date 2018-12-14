<?php
/**
 * BroadcastServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

/**
 * Class BroadcastServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
