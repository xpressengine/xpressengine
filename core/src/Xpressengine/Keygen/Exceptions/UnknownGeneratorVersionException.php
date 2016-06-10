<?php
/**
 * This file is exception for unknown generator call.
 *
 * PHP version 5
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class UnknownGeneratorVersionException extends KeygenException
{
    protected $message = 'Unknown version [#:version]';
}
