<?php
/**
 * This file is already division table exists exception
 *
 * PHP version 5
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Comment\Exceptions;

use Xpressengine\Comment\Exception;

/**
 * 생성하려는 division table 이 이미 존재할 경우 발생
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class AlreadyExistsTableException extends Exception
{
    /**
     * constructor
     *
     * @param string    $table    table name
     * @param string    $message  error message
     * @param int       $code     error code
     * @param Exception $previous previous exception
     */
    public function __construct($table, $message = "", $code = 0, Exception $previous = null)
    {
        // todo.
    }
}
