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
 * InvalidArgumentHttpException
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 */
class InvalidArgumentHttpException extends HttpXpressengineException
{
    /**
     * @var int status code
     */
    protected $statusCode = 403;

    /**
     * getStatusCode
     *
     * @return int status code
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
