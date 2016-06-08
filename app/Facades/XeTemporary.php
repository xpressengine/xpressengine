<?php
/**
 * XeTemporary
 *
 * @category    Temporary
 * @package     Xpressengine\Temporary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * facade 사용을 위한 연결 클래스.
 *
 * @category    Temporary
 * @package     Xpressengine\Temporary
 * @see         Xpressengine\Temporary\TemporaryHandler
 */
class XeTemporary extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.temporary';

    }
}
