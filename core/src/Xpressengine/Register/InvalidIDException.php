<?php
/**
 * InvalidIDException class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Register;

use Xpressengine\Support\Exceptions\XpressengineException;

/**
 * register에 등록될 data의 id의 형식이 잘못됐을 경우 발생하는 예외
 *
 * @category    Register
 * @package     Xpressengine\Register
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class InvalidIDException extends XpressengineException
{
    protected $message = 'ID(:id) 형식이 잘못되었습니다.';
}
