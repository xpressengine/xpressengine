<?php
/**
 * RequiredDF.php
 *
 * PHP version 7
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Middleware;

use App\Facades\XeDynamicField;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class RequiredDF
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class RequiredDF
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request request
     * @param \Closure                 $next    to be called next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() &&
            !Auth::user()->isAdmin() &&
            !$request->routeIs('auth.pending_admin', 'auth.pending_email', 'auth.register.add', 'logout')
        ) {
            $fields = XeDynamicField::gets('user');

            if (count($fields) < 1) {
                return $next($request);
            }

            $rules = Collection::make($fields)->filter(function ($field) {
                return $field->isEnabled();
            })->map(function ($field) {
                return $field->getRules();
            })->collapse()->filter(function ($rules) {
                $rules = array_map('\Illuminate\Support\Str::snake', explode('|', $rules));
                return in_array('required', $rules);
            })->map(function () {
                return 'required';
            });

            if (Validator::make(Auth::user()->getAttributes(), $rules->all())->fails()) {
                return redirect()->route('auth.register.add');
            }
        }

        return $next($request);
    }
}
