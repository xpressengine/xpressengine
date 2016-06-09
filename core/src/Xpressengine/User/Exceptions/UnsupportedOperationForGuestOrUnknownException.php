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
 * Guest 계정이 제공하지 않는 기능을 사용하려고 할 경우 발생하는 Exception
 *
 * @category    User
 * @package     Xpressengine\User
 */
class UnsupportedOperationForGuestOrUnknownException extends UserException
{
    protected $message = 'Guest 또는 Unknown 회원은 해당 기능을 제공하지 않습니다.';
}
