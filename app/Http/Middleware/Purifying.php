<?php
/**
 * Purifying.php
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

use Closure;

/**
 * Class Purifying
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
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

    /**
     * Run the purifier for a given inputs.
     *
     * @param array $input inputs
     * @return array
     */
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
