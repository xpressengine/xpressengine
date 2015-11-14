<?php
/**
 * Instance Route
 *
 * PHP version 5
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Routing;

use Xpressengine\Support\EntityTrait;

/**
 * Instance Route
 *
 * @category Routing
 * @package  Xpressengine\Routing
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 *
 * @property string $url        url
 * @property string $module     module id
 * @property string $instanceId instance Id
 * @property string $menuId     menu id
 * @property string $site       site key
 */
class InstanceRoute
{
    use EntityTrait;
}
