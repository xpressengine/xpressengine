<?php
/**
 * This file is exception for unknown generator call.
 *
 * PHP version 7
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Keygen\Exceptions;

use Xpressengine\Keygen\KeygenException;

/**
 * 잘못된 생성자 호출시 발생되는 예외
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UnknownGeneratorVersionException extends KeygenException
{
    protected $message = 'Unknown version [#:version]';
}
