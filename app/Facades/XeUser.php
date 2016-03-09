<?php
/**
 * This file is accessor for use User by facade
 *
 * PHP version 5
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * 그룹처리기능을 facade를 이용하여 할 수 있게 하기 위함.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
