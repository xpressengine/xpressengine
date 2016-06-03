<?php
/**
 *  This file is part of the Xpressengine package.
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
 * 이미 인증처리된 이메일을 다시 인증시도할 경우 발생하는 Exception
 *
 * @category    User
 * @package     Xpressengine\User
 */
class AlreadyConfirmedEmailException extends UserException
{
    protected $message = '이미 인증된 이메일입니다.';
}
