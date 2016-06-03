<?php
/**
 * This file is unknown criterion exception.
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
 * 비교대상 등급 문자가 정의 되지 않은 문자인 경우 발생하는 Exception
 *
 * @category    User
 * @package     Xpressengine\User
 */
class UnknownCriterionException extends UserException
{
    protected $message = 'Unknown criterion [:criterion]';
}
