<?php
/**
 * AlreadyExistsKey Exception class. This file is part of the Xpressengine package.
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
 * 이미 존재하는 register key를 등록할 때 출력되는 예외 클래스
 *
*@category    Register
 * @package     Xpressengine\Register
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class AlreadyExistsKeyException extends RegisterException
{
    protected $message = 'xe::alreadyExistsRegisterKey';
}
