<?php
/**
 * RequiredDF.php
 *
 * PHP version 7
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class RequiredDF
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request request
     * @param \Closure                 $next    to be called next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (
            Auth::check() &&
            !Auth::user()->isAdmin() &&
            !$request->routeIs('auth.register.add', 'logout')
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
            })->map(function () {return 'required';});

            if (Validator::make(Auth::user()->getAttributes(), $rules->all())->fails()) {
                return redirect()->route('auth.register.add');
            }
        }

        return $next($request);
    }
}
