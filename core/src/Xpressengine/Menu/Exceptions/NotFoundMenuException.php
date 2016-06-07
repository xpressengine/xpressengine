<?php
/**
 * Class NotFountMenuException
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
 * Menu RuntimeException
 *
 * @category Menu
 * @package  Xpressengine\Menu
 */

class NotFoundMenuException extends MenuException
{
    protected $message = 'MenuEntity 를 찾을 수 없습니다.';
}
