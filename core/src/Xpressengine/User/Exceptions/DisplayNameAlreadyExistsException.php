<?php
/**
 * This file is already exists input mail address exception.
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
 * 이미 존재하는 표시이름을 사용하려고 할 경우 발생하는 Exception
 *
 * @category    User
 * @package     Xpressengine\User
 */
class DisplayNameAlreadyExistsException extends UserException
{
    protected $message = '이미 사용중인 회원 이름입니다.';
}
