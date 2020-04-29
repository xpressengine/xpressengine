<?php
/**
 * NotConfigurationWidgetException
 *
 * PHP version 7
 *
 * @category  Widget
 * @package   Xpressengine\Widget
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Widget\Exceptions;

use Exception;
use Xpressengine\Widget\WidgetException;

/**
 * NotConfigurationWidgetException
 *
 * PHP version 7
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class NotConfigurationWidgetException extends WidgetException
{
    protected $message = 'Widget configuration is not set.';
}
