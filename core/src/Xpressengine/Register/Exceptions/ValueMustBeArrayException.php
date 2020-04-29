<?php
/**
 * InvalidIDException class. This file is part of the Xpressengine package.
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

namespace Xpressengine\Register\Exceptions;

use Xpressengine\Support\Exceptions\XpressengineException;

/**
 * register에 등록될 data의 id의 형식이 잘못됐을 경우 발생하는 예외
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ValueMustBeArrayException extends XpressengineException
{
    protected $message = 'The value of the specified key is not an array type.';
}
