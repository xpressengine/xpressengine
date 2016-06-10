<?php
/**
 * XeToggleMenu
 *
 * PHP version 5
 *
 * @category    ToggleMenu
 * @package     Xpressengine\ToggleMenu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * facade 사용을 위한 클래스.
 *
 * @category    ToggleMenu
 * @package     Xpressengine\ToggleMenu
 * @see         Xpressengine\ToggleMenu\ToggleMenuHandler
 */
class XeToggleMenu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.toggleMenu';
    }
}
