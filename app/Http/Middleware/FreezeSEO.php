<?php
/**
 * FreezeSEO.php
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

/**
 * Class FreezeSEO
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
