<?php
/**
 * SettingsMenuPermission class.
 *
 * PHP version 5
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Settings;

use Xpressengine\Permission\Action;
use Xpressengine\Permission\Permissions\AbstractRegisteredPermission;
use Xpressengine\Permission\Permission;
use Xpressengine\User\UserInterface;

/**
 * 관리권한을 표현하는 클래스이다. 이 클래스는 Xpressengine Permission을 확장하기 위해 사용된다.
 *
 * @category Settings
 * @package  Xpressengine\Settings
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 *
 * @deprecated
 */
class SettingsMenuPermission extends AbstractRegisteredPermission
{
    /**
     * Support actions. 관리권한에서는 Access action만을 사용한다.
     *
     * @var array
     */
    protected $actions = [Action::ACCESS];

    /**
     * Constructor
     *
     * @param UserInterface $user       current user
     * @param Permission            $registered Registered instance
     */
    public function __construct(UserInterface $user = null, Permission $registered = null)
    {
        $this->user = $user;

        parent::__construct($registered);
    }
}
