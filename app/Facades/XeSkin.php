<?php
/**
 * XeSkin
 *
 * PHP version 5
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     LGPL-2.1 http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * facade 로 사용하기 위한 연결
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @see         Xpressengine\Skin\SkinHandler
 */
class XeSkin extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.skin';
    }
}
