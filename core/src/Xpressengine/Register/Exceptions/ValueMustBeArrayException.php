<?php
/**
 * InvalidIDException class. This file is part of the Xpressengine package.
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Register\Exceptions;

use Xpressengine\Support\Exceptions\XpressengineException;

/**
 * register에 등록될 data의 id의 형식이 잘못됐을 경우 발생하는 예외
 *
 * @category    Register
 * @package     Xpressengine\Register
 */
class ValueMustBeArrayException extends XpressengineException
{
    protected $message = '지정된 키의 값이 배열형식이 아닙니다.';
}
