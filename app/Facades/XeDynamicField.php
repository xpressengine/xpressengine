<?php
/**
 * XeDynamicField
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * facade 로 이용 하기위해 선언되어진 클래스
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @see         Xpressengine\DynamicField\DynamicFieldHandler
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
