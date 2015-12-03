<?php
/**
 * This file is exception of wrong instance.
 *
 * PHP version 5
 *
 * @category    ToggleMenu
 * @package     Xpressengine\ToggleMenu
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\ToggleMenu\Exceptions;

use Xpressengine\ToggleMenu\Exception;

/**
 * 메뉴아이템 instance 가 유효하지 않은 경우
 *
 * @category    ToggleMenu
 * @package     Xpressengine\ToggleMenu
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class WrongInstanceException extends Exception
{
    protected $message = '잘못된 instance 입니다.';
}
