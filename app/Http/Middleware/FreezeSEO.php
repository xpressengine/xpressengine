<?php
/**
 * FreezeSEO.php
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

/**
 * Class FreezeSEO
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class FreezeSEO
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request request
     * @param  \Closure                  $next    to be called next
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
