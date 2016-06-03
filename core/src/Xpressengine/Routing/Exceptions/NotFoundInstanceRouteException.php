<?php
/**
 * Class NotFoundInstanceRouteException
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Routing\Exceptions;

use Xpressengine\Routing\RoutingException;

/**
 * Routing RuntimeException
 *
 * @category Routing
 * @package  Xpressengine\Routing
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class NotFoundInstanceRouteException extends RoutingException
{
    protected $message = 'InstanceRoute 를 찾을 수 없습니다.';
}
