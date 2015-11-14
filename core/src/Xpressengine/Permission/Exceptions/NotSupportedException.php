<?php
/**
 * This file is not supported exception
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Permission\Exceptions;

use Xpressengine\Permission\Exception;

/**
 * 지원되지 않는 case 에 대한 exception
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class NotSupportedException extends Exception
{
    /**
     * constructor
     *
     * @param array     $args     arguments
     * @param string    $message  message string
     * @param int       $code     error code
     * @param Exception $previous previous exception
     */
    public function __construct($args = [], $message = "", $code = 0, Exception $previous = null)
    {
        if (isset($args['action']) === true) {
            $this->message = sprintf('Not supported action [%s]', $args['action']);
        }
    }
}
