<?php
/**
 * RegisterException class. This file is part of the Xpressengine package.
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
namespace Xpressengine\Register;

use Xpressengine\Support\Exceptions\XpressengineException;

/**
 * register 패키지에서 사용되는 exception의 부모클래스
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class RegisterException extends XpressengineException
{
    protected $message = 'Xpressengine Register package exception';
}
