<?php
/**
 *  AccessDeniedHttpException Class
 *
 * PHP version 7
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * AccessDeniedHttpException
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class AccessDeniedHttpException extends HttpXpressengineException
{
    /**
     * @var string
     */
    protected $message = 'xe::accessDenied';

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
