<?php
/**
 * This file is the exception of not exists item.
 *
 * PHP version 5
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Config\Exceptions;

use Xpressengine\Config\Exception;

/**
 * 대상이 존재하지 않는 경우
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class NotExistsException extends Exception
{
    protected $message = '":name" 은 존재하지 않습니다.';
}
