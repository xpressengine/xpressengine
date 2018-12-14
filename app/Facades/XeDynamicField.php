<?php
/**
 * XeDynamicField.php
 *
 * PHP version 7
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class XeDynamicField
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @see         Xpressengine\DynamicField\DynamicFieldHandler
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class XeDynamicField extends Facade
{

    /**
     * facade access keyword
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.dynamicField';
    }
}
