<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\User\Repositories;

use Xpressengine\User\GroupInterface;
use Xpressengine\User\UserInterface;

/**
 * 회원 그룹 정보를 저장하는 Repository
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UserGroupRepository implements UserGroupRepositoryInterface
{
    use RepositoryTrait;

    /**
     * UserGroupRepository constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->setModel($model);
    }

    /**
     * delete
     *
     * @param $group
     *
     * @return bool
     */
    public function delete($group)
    {
        if ($group->exists) {
            $group->users()->detach();
        }
        return $group->delete();
    }

    /**
     * 주어진 그룹에 주어진 회원을 추가한다.
     *
     * @param GroupInterface $group 대상 그룹
     * @param UserInterface  $user  추가할 회원
     *
     * @return mixed
     */
    public function addUser($group, $user)
    {
        return $group->addUser($user);
    }

    /**
     * 주어진 회원을 그룹에서 제외시킨다.
     *
     * @param GroupInterface $group 대상 그룹
     * @param UserInterface  $user  제외시킬 회원
     *
     * @return void
     */
    public function exceptUser($group, $user)
    {
        return $group->exceptUser($user);
    }
}
