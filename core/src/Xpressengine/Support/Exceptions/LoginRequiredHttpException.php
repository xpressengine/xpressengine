<?php
/**
 *  LoginRequiredHttpException
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
 * LoginRequiredHttpException
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class LoginRequiredHttpException extends HttpXpressengineException
{
    /**
     * @var string
     */
    protected $message = 'xe::msgLoginRequired';

    /**
     * @var int
     */
    protected $statusCode = Response::HTTP_UNAUTHORIZED;
}
