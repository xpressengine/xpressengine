<?php
/**
 * This file is invalid argument exception
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

use Xpressengine\Comment\CommentException;

/**
 * 유효하지 않은 인자가 전달된 경우 발생
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class InvalidObjectException extends CommentException
{
    protected $message = '유효하지 않은 객체 입니다.';
}
