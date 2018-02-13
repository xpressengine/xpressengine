<?php

namespace App\Http\Middleware;

use App\Facades\XeDynamicField;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
