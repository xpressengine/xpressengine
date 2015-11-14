<?php
namespace App\Http\Middleware;

use Closure;

class Purifying
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
        if (!$request->isManageRequest()) {
            $inputs = $request->except('_token');

            $request->merge($this->execute($inputs));
        }

        return $next($request);
    }

    protected function execute($input)
    {
        if (is_array($input) === true) {
            return array_map(function ($item) {
                return $this->execute($item);
            }, $input);
        }

        return $input != strip_tags($input) ? app('purifier')->purify($input) : $input;
    }
}
