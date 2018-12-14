<?php
/**
 * EventServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
