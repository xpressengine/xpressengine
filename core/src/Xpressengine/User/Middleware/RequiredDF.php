<?php
/**
 * RequiredDF.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Middleware;

use Closure;

class RequiredDF
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->isAdmin()) {
            $DF = app('xe.dynamicField');
            $fields = $DF->gets('user');

            if (count($fields) < 1) {
                return $next($request);
            }

            $rules = collect($fields)->filter(function ($field) {
                return $field->isEnabled();
            })->map(function ($field) {
                return $field->getRules();
            })->collapse()->filter(function ($rules) {
                $rules = array_map('\Illuminate\Support\Str::snake', explode('|', $rules));
                return in_array('required', $rules);
            })->map(function () {return 'required';});

            if (validator(auth()->user()->getAttributes(), $rules->all())->fails()) {
                // todo: redirect
                dd('!!!');
            }
        }

        return $next($request);
    }
}