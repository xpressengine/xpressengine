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
 * 존재하지 않는 이메일을 사용하려고 할 경우 발생하는 Exception
 *
 * @category    User
 * @package     Xpressengine\User
 */
class EmailNotFoundException extends UserException
{
    protected $message = '존재하지 않는 이메일입니다';
}
