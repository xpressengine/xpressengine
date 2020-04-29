<?php
/**
 * ModelNotSupportDynamicModeException
 *
 * PHP version 7
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Database\Exceptions;

use Xpressengine\Database\DatabaseException;

/**
 * ModelNotSupportDynamicModeException
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ModelNotSupportDynamicModeException extends DatabaseException
{
    protected $message = 'This Model is not supported "dynamic" mode.';
}
