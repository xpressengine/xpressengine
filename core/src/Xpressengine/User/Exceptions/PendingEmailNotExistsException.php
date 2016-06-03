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
 * 존재하지 않는 등록 대기 이메일을 조회할 경우 발생하는 Exception
 *
 * @category    User
 * @package     Xpressengine\User
 */
class PendingEmailNotExistsException extends UserException
{
    protected $message = '인증 요청중인 이메일이 없습니다.';
}
