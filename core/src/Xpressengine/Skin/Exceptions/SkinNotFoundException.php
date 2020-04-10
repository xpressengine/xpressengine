<?php
/**
 * SkinNotFoundException class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Skin\Exceptions;

use Xpressengine\Skin\SkinException;

/**
 * 스킨을 찾을 수 없을 경우 발생하는 예외이다.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SkinNotFoundException extends SkinException
{
    protected $message = 'Skin not found.';
}
