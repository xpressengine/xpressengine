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

/**
 * InvalidArgumentHttpException
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
