<?php
/**
 * UriValidator
 *
 * PHP version 7
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Routing;

use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

/**
 * Class UriValidator
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UriValidator implements ValidatorInterface
{
    use InstanceRouteChecker;

    /**
     * Validate a given rule against a route and request.
     *
     * @param  Route   $route   illuminate route
     * @param  Request $request illuminate request
     *
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        if ($request->segment(1) === null && $this->isInstance($route)) {
            return true;
        } else {
            $path = $request->decodedPath() == '/' ? '/' : '/' . $request->decodedPath();

            return preg_match($route->getCompiled()->getRegex(), $path);
        }
    }
}
