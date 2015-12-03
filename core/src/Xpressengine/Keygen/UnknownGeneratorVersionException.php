<?php
/**
 * This file is exception for unknown generator call.
 *
 * PHP version 5
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Keygen;

use Xpressengine\Support\Exceptions\XpressengineException;

/**
 * 잘못된 생성자 호출시 발생되는 예외
 *
 * @category    Keygen
 * @package     Xpressengine\Keygen
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UnknownGeneratorVersionException extends XpressengineException
{
    protected $message = 'Unknown version [#:version]';
}
