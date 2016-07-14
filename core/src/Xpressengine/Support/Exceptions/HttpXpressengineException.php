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
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * HttpXpressengineException
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class HttpXpressengineException extends XpressengineException implements HttpExceptionInterface
{
    protected $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * HttpXpressengineException constructor.
     *
     * @param array           $args       arguments array
     * @param int             $statusCode exception status code
     * @param \Exception|null $previous   exception
     * @param array           $headers    header
     * @param int             $code       code
     */
    public function __construct(
        $args = [],
        $statusCode = null,
        \Exception $previous = null,
        array $headers = [],
        $code = 0
    ) {

        if ($statusCode !== null) {
            $this->statusCode = $statusCode;
        }
        $this->headers = $headers;

        parent::__construct($args, $code, $previous);
    }

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
     * Returns response headers.
     *
     * @return array Response headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
