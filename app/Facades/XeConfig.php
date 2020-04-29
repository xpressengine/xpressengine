<?php
/**
 * XeConfig.php
 *
 * PHP version 7
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class XeConfig
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @see         Xpressengine\Config\ConfigManager
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class XeConfig extends Facade
{
    /**
     * facade access keyword
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.config';
    }
}
