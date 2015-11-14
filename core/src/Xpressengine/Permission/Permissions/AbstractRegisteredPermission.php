<?php
/**
 * This file is a permission of used registered information.
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

use Xpressengine\Member\Rating;
use Xpressengine\Permission\Permission;
use Xpressengine\Permission\Registered;
use Xpressengine\Permission\Grant;
use Xpressengine\Member\Repositories\VirtualGroupRepositoryInterface;

/**
 * register 동작을 통해 저장된 권한 정보를 이용하여
 * 처리되는 클래스를 정의하는 추상 클래스.
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class AbstractRegisteredPermission extends Permission
{
    /**
     * @var VirtualGroupRepositoryInterface
     */
    protected static $vgroups;

    /**
     * Registered instance
     *
     * @var Registered
     */
    protected $registered;

    /**
     * Constructor
     *
     * @param Registered $registered Registered instance
     */
    public function __construct(Registered $registered = null)
    {
        $this->registered = $registered;
    }

    /**
     * 권한 유무 판별
     *
     * @param string $action action keyword
     * @return bool
     */
    protected function judge($action)
    {
        $grants = $this->registered[$action] ?: [];

        // 제외대상 정보를 추출하면서 전체 정보에서 제외대상 정보를 제거함
        $excepts = $this->extractExcepts($grants);

        // 제외대상 회원 우선 처리
        if ($this->isExcepted($excepts) === true) {
            return false;
        }

        $result = false;
        foreach ($grants as $type => $value) {
            if ($this->checker($type, $value)) {
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
     * @param array $userIds except target identifiers
     * @return bool
     */
    protected function isExcepted(array $userIds = [])
    {
        if (empty($userIds) === true || $this->isGuest()) {
            return false;
        }

        return in_array($this->user->getId(), $userIds) ?: false;
    }

    /**
     * 타입에 맞는 권한 판별 메서드를 호출 함.
     *
     * @param string $type  check type
     * @param mixed  $value given value
     * @return bool
     */
    protected function checker($type, $value)
    {
        $inspectMethod = $type . 'Inspect';

        return $this->$inspectMethod($value);
    }

    /**
     * User 가 속한 그룹이 권한이 있는지 판별.
     *
     * @param array $criterion criterion group ids
     * @return bool
     */
    protected function groupInspect($criterion)
    {
        $groups = $this->user->getGroups();
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
     * @param array $criterion criterion vgroup ids
     * @return bool
     */
    protected function vgroupInspect($criterion)
    {
        if ($this->isGuest()) {
            return false;
        }

        $groups = static::$vgroups->fetchAllByMember($this->user->getId());
        $groups = array_map(function ($group) {
            return $group->id;
        }, $groups);

        $intersect = array_intersect($groups, $criterion);

        return !empty($intersect);
    }

    /**
     * User 가 권한이 있는 대상으로 지정되어 있는지 판별
     *
     * @param array $criterion criterion user ids
     * @return bool
     */
    protected function userInspect($criterion)
    {
        if (!$this->isGuest() && in_array($this->user->getId(), $criterion)) {
            return true;
        }

        return false;
    }

    /**
     * User 가 권한이 있는 등급인지 판별
     *
     * @param string $criterion user rating keyword
     * @return bool
     */
    protected function ratingInspect($criterion)
    {
        if (Rating::compare($this->userRating(), $criterion) == -1) {
            return false;
        }

        return true;
    }

    /**
     * Get a User's rating keyword
     *
     * @return string
     */
    protected function userRating()
    {
        if ($this->isGuest() === true) {
            return Rating::GUEST;
        }

        return $this->user->getRating();
    }

    /**
     * Registered instance
     *
     * @return Registered
     */
    public function getRegistered()
    {
        return $this->registered;
    }

    /**
     * @param VirtualGroupRepositoryInterface $vgroups virtual group repo instance
     * @return void;
     */
    public static function setVirtualGroupRepository(VirtualGroupRepositoryInterface $vgroups)
    {
        static::$vgroups = $vgroups;
    }
}
