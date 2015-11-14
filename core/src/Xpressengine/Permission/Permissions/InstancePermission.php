<?php
/**
 * This file is a instance permission.
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Permission\Permissions;

use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Permission\Action;
use Xpressengine\Permission\Registered;

/**
 * 사용자가 특정 instance 의 action 에 대한 권한이 있는지 여부를 제공해주는 클래스.
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class InstancePermission extends AbstractRegisteredPermission
{
    /**
     * Support actions
     *
     * @var array
     */
    protected $actions = [
        Action::CREATE, Action::READ, Action::UPDATE, Action::DELETE, Action::MOVE,
        Action::UPLOAD, Action::DOWNLOAD,
    ];

    /**
     * Constructor
     *
     * @param string                $name       target instance name
     * @param MemberEntityInterface $user       User instance
     * @param Registered            $registered Registered instance
     */
    public function __construct($name, MemberEntityInterface $user = null, Registered $registered = null)
    {
        $this->target = $name;
        $this->user = $user;

        parent::__construct($registered);
    }
}
