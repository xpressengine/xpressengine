<?php
/**
 * SkinNotFoundException class. This file is part of the Xpressengine package.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Skin\Exceptions;

use Xpressengine\Skin\SkinException;

/**
 * 스킨을 찾을 수 없을 경우 발생하는 예외이다.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SkinNotFoundException extends SkinException
{
    protected $message = 'Skin을 찾을 수 없습니다';
}
