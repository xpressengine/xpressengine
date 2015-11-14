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

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * HttpXpressengineException
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class HttpXpressengineException extends XpressengineException implements HttpExceptionInterface
{
    /**
     * HttpXpressengineException constructor.
     *
     * @param int             $statusCode exception status code
     * @param array           $args       arguments array
     * @param \Exception|null $previous   exception
     * @param array           $headers    header
     * @param int             $code       code
     */
    public function __construct(
        $statusCode = null,
        $args = [],
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
