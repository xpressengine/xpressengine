<?php
/**
 * CanNotCreateItemException
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Menu\Exceptions;

use Xpressengine\Menu\MenuException;

/**
 * CanNotCreateItemException
 *
 * @category Menu
 * @package  Xpressengine\Menu
 */
class CanNotCreateItemException extends MenuException
{
    protected $message = 'MenuItem 을 생성할 수 없습니다';
}
