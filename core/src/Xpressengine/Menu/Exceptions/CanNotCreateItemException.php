<?php
/**
 * CanNotCreateItemException
 *
 * PHP version 7
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Menu\Exceptions;

use Xpressengine\Menu\MenuException;

/**
 * CanNotCreateItemException
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */
class CanNotCreateItemException extends MenuException
{
    protected $message = 'Unable to create MenuItem.';
}
