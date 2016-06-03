<?php
/**
 * UriValidator
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Routing;

use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Route as LaravelRoute;

/**
 * Class UriValidator
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UriValidator implements ValidatorInterface
{

    /**
     * Validate a given rule against a route and request.
     *
     * @param  LaravelRoute   $route   illuminate route
     * @param  LaravelRequest $request illuminate request
     *
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        $path = $request->path() == '/' ? '/' : '/' . $request->path();
        $firstSegment = $request->segment(1);
        if ($firstSegment === null) {
            return true;
        } else {
            return preg_match($route->getCompiled()->getRegex(), rawurldecode($path));
        }
    }
}
