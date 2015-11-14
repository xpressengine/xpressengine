<?php
namespace App\Http\Middleware;

class FreezeSEO
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($request->isManageRequest()) {
            app('xe.seo')->notExec();
        }

        return $next($request);
    }
}
