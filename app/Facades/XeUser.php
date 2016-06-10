<?php
/**
 * XeUser
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * 그룹처리기능을 facade를 이용하여 할 수 있게 하기 위함.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 * @see         Xpressengine\User\UserHandler
 */
class XeUser extends Facade
{
    const PROVIDER_DEFAULT = 'default';

    const STATUS_DENIED = 'denied';
    const STATUS_ACTIVATED = 'activated';

    public static $status = [
        self::STATUS_DENIED,
        self::STATUS_ACTIVATED
    ];

    /**
     * facade access keyword
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.user';
    }
}
