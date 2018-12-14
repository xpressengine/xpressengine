<?php
/**
 * RedirectIfAuthenticated.php
 *
 * PHP version 7
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class RedirectIfAuthenticated
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request request
     * @param  \Closure                  $next    to be called next
     * @param  string|null               $guard   guard name
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
