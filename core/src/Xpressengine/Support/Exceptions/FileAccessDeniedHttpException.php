<?php
/**
 *  AccessDeniedHttpException Class
 *
 * PHP version 5
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support\Exceptions;

/**
 * FileAccessDeniedHttpException
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 */
class FileAccessDeniedHttpException extends HttpXpressengineException
{
    /**
     * @var string $message exception message
     */
    protected $message = '파일을 수정할 권한이 없습니다.';

    /**
     * @var int $statusCode exception http code
     */
    protected $statusCode = 403;
}
