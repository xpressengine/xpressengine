<?php
/**
 * XeWidgetBox.php
 *
 * PHP version 7
 *
 * @category    WidgetBox
 * @package     Xpressengine\WidgetBox
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class XeWidgetBox
 *
 * @category    WidgetBox
 * @package     Xpressengine\WidgetBox
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 * @see         Xpressengine\Widget\WidgetBoxHandler
 */
class XeWidgetBox extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.widgetbox';
    }
}
