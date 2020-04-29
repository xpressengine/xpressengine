<?php
/**
 * Class NotFoundInstanceRouteException
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

namespace Xpressengine\Routing\Exceptions;

use Xpressengine\Routing\RoutingException;

/**
 * Routing RuntimeException
 *
 * @category Routing
 * @package  Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class NotFoundInstanceRouteException extends RoutingException
{
    protected $message = 'InstanceRoute not found.';
}
