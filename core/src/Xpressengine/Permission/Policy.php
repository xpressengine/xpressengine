<?php
/**
 * This file is the abstract policy for permission.
 *
 * PHP version 7
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Permission;

use Xpressengine\User\Models\Guest;
use Xpressengine\User\Rating;
use Xpressengine\User\Repositories\VirtualGroupRepositoryInterface;
use Xpressengine\User\UserInterface;

/**
 * Abstract class Policy
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class Policy
{
    /**
     * PermissionHandler instance
     *
     * @var PermissionHandler
     */
    protected $perm;

    /**
     * VirtualGroupRepository instance
     *
     * @var VirtualGroupRepositoryInterface
     */
    protected $vgroups;

    /**
     * Policy constructor.
     * @param PermissionHandler               $perm    PermissionHandler instance
     * @param VirtualGroupRepositoryInterface $vgroups VirtualGroupRepository instance
     */
    public function __construct(PermissionHandler $perm, VirtualGroupRepositoryInterface $vgroups)
    {
        $this->perm = $perm;
        $this->vgroups = $vgroups;
    }

    /**
     * Get a permission
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return Permission|null
     */
    protected function get($name, $siteKey = 'default')
    {
        return $this->perm->get($name, $siteKey);
    }

    /**
     * Check allows
     *
     * @param UserInterface $user       user instance
     * @param Permission    $permission permission instance
     * @param string        $action     action keyword
     * @return bool
     */
    protected function check(UserInterface $user, Permission $permission, $action)
    {
        $grants = $permission[$action] ?: [];

        // 제외대상 정보를 추출하면서 전체 정보에서 제외대상 정보를 제거함
        $excepts = $this->extractExcepts($grants);

        // 제외대상 회원 우선 처리
        if ($this->isExcepted($user, $excepts) === true) {
            return false;
        }

        $result = false;
        foreach ($grants as $type => $value) {
            if ($this->checker($user, $type, $value)) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * Extract except user information
     *
     * @param array $grants all grants information
     * @return array user identifiers
     */
    protected function extractExcepts(array &$grants)
    {
        $excepts = isset($grants[Grant::EXCEPT_TYPE]) ? $grants[Grant::EXCEPT_TYPE] : [];

        if (!empty($excepts) || count($excepts) == 0) {
            unset($grants[Grant::EXCEPT_TYPE]);
        }

        return $excepts;
    }

    /**
     * Check except user
     *
     * @param UserInterface $user    user instance
     * @param array         $userIds except target identifiers
     * @return bool
     */
    protected function isExcepted(UserInterface $user, array $userIds = [])
    {
        if (empty($userIds) === true || $this->isGuest($user)) {
            return false;
        }

        return in_array($user->getId(), $userIds) ?: false;
    }

    /**
     * 타입에 맞는 권한 판별 메서드를 호출 함.
     *
     * @param UserInterface $user  user instance
     * @param string        $type  check type
     * @param mixed         $value given value
     * @return bool
     */
    protected function checker(UserInterface $user, $type, $value)
    {
        $inspectMethod = $type . 'Inspect';

        return $this->$inspectMethod($user, $value);
    }

    /**
     * User 가 속한 그룹이 권한이 있는지 판별.
     *
     * @param UserInterface $user      user instance
     * @param array         $criterion criterion group ids
     * @return bool
     */
    protected function groupInspect(UserInterface $user, $criterion)
    {
        $groups = $user->getGroups();
        foreach ($groups as $group) {
            if (in_array($group->id, $criterion)) {
                return true;
            }
        }

        return false;
    }

    /**
     * User 가 속한 가상그룹이 권한이 있는지 판별.
     *
     * @param UserInterface $user      user instance
     * @param array         $criterion criterion vgroup ids
     * @return bool
     */
    protected function vgroupInspect(UserInterface $user, $criterion)
    {
        if ($this->isGuest($user)) {
            return false;
        }

        $groups = $this->vgroups->findByUserId($user->getId());
        $groups = array_map(function ($group) {
            return $group->id;
        }, $groups);

        $intersect = array_intersect($groups, $criterion);

        return !empty($intersect);
    }

    /**
     * User 가 권한이 있는 대상으로 지정되어 있는지 판별
     *
     * @param UserInterface $user      user instance
     * @param array         $criterion criterion user ids
     * @return bool
     */
    protected function userInspect(UserInterface $user, $criterion)
    {
        if (!$this->isGuest($user) && in_array($user->getId(), $criterion)) {
            return true;
        }

        return false;
    }

    /**
     * User 가 권한이 있는 등급인지 판별
     *
     * @param UserInterface $user      user instance
     * @param string        $criterion user rating keyword
     * @return bool
     */
    protected function ratingInspect(UserInterface $user, $criterion)
    {
        if (Rating::compare($this->userRating($user), $criterion) == -1) {
            return false;
        }

        return true;
    }

    /**
     * Get a User's rating keyword
     *
     * @param UserInterface $user user instance
     * @return string
     */
    protected function userRating(UserInterface $user)
    {
        if ($this->isGuest($user) === true) {
            return Rating::GUEST;
        }

        return $user->getRating();
    }

    /**
     * 전달된 사용자가 guest 인지 확인
     *
     * @param UserInterface $user user instance
     * @return bool
     */
    protected function isGuest(UserInterface $user)
    {
        return $user instanceof Guest;
    }
}
