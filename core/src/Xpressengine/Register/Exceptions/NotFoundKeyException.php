<?php
/**
 * NotFoundKeyException Exception class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Register\Exceptions;

use Xpressengine\Register\RegisterException;

/**
 * 존재하지 않는 register key를 조회할 때 출력되는 예외 클래스
 *
*@category    Register
 * @package     Xpressengine\Register
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class NotFoundKeyException extends RegisterException
{
    protected $message = 'xe::notFoundRegisterKey';
}
