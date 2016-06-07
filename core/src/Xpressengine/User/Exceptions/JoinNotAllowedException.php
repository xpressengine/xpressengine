<?php
/**
 * This file is blocked joining system exception.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Exceptions;

use Xpressengine\User\UserException;

/**
 * 회원가입을 할 수 없을 때 발생하는 Exception
 *
 * @category    User
 * @package     Xpressengine\User
 */
class JoinNotAllowedException extends UserException
{
    protected $message = '관리자가 회원가입을 허용하지 않습니다.';
}
