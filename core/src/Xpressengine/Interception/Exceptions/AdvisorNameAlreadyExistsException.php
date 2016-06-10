<?php
/**
 * This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Interception\Exceptions;

use Xpressengine\Interception\InterceptionException;

/**
 * 중복된 advisor 이름이 등록되었을 때 발생하는 예외
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class AdvisorNameAlreadyExistsException extends InterceptionException
{
    protected $message = 'Advisor[:name] already exists.';
}
