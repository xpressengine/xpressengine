<?php
/**
 * Menu Permission
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Menu\Permission;

use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Permission\Action;
use Xpressengine\Permission\Permissions\AbstractRegisteredPermission;
use Xpressengine\Permission\Permission;

/**
 * MenuPermission
 *
 * @category Menu
 * @package  Xpressengine\Menu\Permission
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 *
 * @deprecated
 */
class MenuPermission extends AbstractRegisteredPermission
{
    /**
     * Support actions
     *
     * @var array
     */
    protected $actions = [Action::ACCESS, ACTION::VISIBLE];

    /**
     * Constructor
     *
     * @param MemberEntityInterface $user       User instance
     * @param Permission            $registered Registered instance
     *
     */
    public function __construct(MemberEntityInterface $user = null, Permission $registered = null)
    {
        $this->user = $user;

        parent::__construct($registered);
    }
}
