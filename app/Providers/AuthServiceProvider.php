<?php
/**
 * AuthServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
