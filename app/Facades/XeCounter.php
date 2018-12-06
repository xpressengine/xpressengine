<?php
/**
 * XeCounter.php
 *
 * PHP version 7
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class XeCounter
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @see         Xpressengine\Counter\Factory
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class XeCounter extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.counter';
    }
}
