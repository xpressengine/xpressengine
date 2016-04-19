<?php
/**
 * XeUI
 *
 * PHP version 5
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * facade 사용을 위한 연결 클래스.
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @see         Xpressengine\UIObject\UIObjectHandler
 */
class XeUI extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.uiobject';
    }
}
