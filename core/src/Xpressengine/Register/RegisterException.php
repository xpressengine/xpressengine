<?php
/**
 * RegisterException class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Register;

use Xpressengine\Support\Exceptions\XpressengineException;

/**
 * register 패키지에서 사용되는 exception의 부모클래스
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class RegisterException extends XpressengineException
{
    protected $message = 'Xpressengine Register package exception';
}
