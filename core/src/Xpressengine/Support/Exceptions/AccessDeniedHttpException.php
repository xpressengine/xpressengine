<?php
/**
 *  AccessDeniedHttpException Class
 *
 * PHP version 5
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Support\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * AccessDeniedHttpException
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class AccessDeniedHttpException extends HttpXpressengineException
{
    /**
     * @var string
     */
    protected $message = 'xe::AccessDenied';

    /**
     * @var int
     */
    protected $statusCode = Response::HTTP_UNAUTHORIZED;

    /**
     * getStatusCode
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * getHeaders
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
