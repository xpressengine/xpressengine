<?php
/**
 * XeDB.php
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

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class XeDB
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @see         Xpressengine\Database\DatabaseHandler
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class XeDB extends Facade
{

    /**
     * facade access keyword
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.db';
    }
}
