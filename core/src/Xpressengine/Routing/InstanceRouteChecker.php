<?php
/**
 * InstanceRouteChecker.php
 *
 * PHP version 7
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Routing;

use Illuminate\Routing\Route;

/**
 * Trait InstanceRouteChecker
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait InstanceRouteChecker
{
    /**
     * Determine the given route is for the instance.
     *
     * @param Route $route illuminate route
     * @return bool
     */
    public function isInstance(Route $route)
    {
        return strpos($route->uri(), '{instanceGroup') === 0;
    }
}
