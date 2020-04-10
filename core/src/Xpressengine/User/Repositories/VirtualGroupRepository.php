<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Repositories;

use Closure;
use Illuminate\Support\Collection;
use Xpressengine\User\Exceptions\UserNotFoundException;
use Xpressengine\User\Models\UserVirtualGroup;

/**
 * 가상 그룹 정보를 저장하는 Repository
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class VirtualGroupRepository implements VirtualGroupRepositoryInterface
{

    /**
     * @var array 가상그룹 리스트
     */
    protected $vgroups;

    /**
     * @var UserRepositoryInterface User Repository
     */
    private $users;

    /**
     * @var Closure
     */
    private $getter;

    /**
     * VirtualGroupRepository constructor.
     *
     * @param UserRepositoryInterface $users       user repository
     * @param array                   $vGroupInfos list of virtual group infos
     * @param Closure                 $getter      Closure for retrieve virtual group list by user id
     */
    public function __construct(UserRepositoryInterface $users, array $vGroupInfos, Closure $getter)
    {
        $this->users = $users;

        $this->vgroups = [];
        /** @var array $entityInfo */
        foreach ($vGroupInfos as $id => $entityInfo) {
            $this->vgroups[$id] = $this->resolveEntity($id, $entityInfo);
        }

        $this->getter = $getter;
    }

    /**
     * 주어진 id에 해당하는 가상그룹 정보를 반환한다.
     *
     * @param string $id 조회할 가상그룹 id
     *
     * @return UserVirtualGroup
     */
    public function find($id)
    {
        return array_get($this->vgroups, $id);
    }

    /**
     * 가상그룹 이름으로 가상그룹을 조회한다.
     *
     * @param string $title 가상그룹 이름
     *
     * @return UserVirtualGroup|null
     */
    public function findByTitle($title)
    {
        foreach ($this->vgroups as $entity) {
            if ($entity->title == $title) {
                return $entity;
            }
        }
    }

    /**
     * 회원이 소속된 가상그룹 목록을 조회한다.
     *
     * @param string $userId 회원아이디
     *
     * @return array
     */
    public function findByUserId($userId)
    {
        $getByUser = $this->getter;
        $user = $this->users->find($userId);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $groupIds = $getByUser($user);

        return array_only($this->vgroups, $groupIds);
    }

    /**
     * 모든 가상그룹 목록을 반환한다.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->vgroups;
    }

    /**
     * 주어진 id를 가진 가상 그룹이 있는지의 여부를 반환한다.
     *
     * @param string $id 조회할 가상그룹 id
     *
     * @return bool
     */
    public function has($id)
    {
        return isset($this->vgroups[$id]);
    }

    /**
     * 주어진 가상그룹 정보로 가상그룹 Entity를 생성하여 반환한다.
     *
     * @param string $id         생성할  가상 그룹 id
     * @param array  $entityInfo 생성할 가상그룹 정보
     *
     * @return UserVirtualGroup
     */
    private function resolveEntity($id, $entityInfo)
    {
        $entityInfo['id'] = $id;
        return new UserVirtualGroup($entityInfo);
    }
}
