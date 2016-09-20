<?php
/**
 * This file is the handler for permission.
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Permission;

use Xpressengine\Permission\Exceptions\InvalidArgumentException;
use Xpressengine\Permission\Exceptions\NoParentException;

/**
 * # Class PermissionHandler
 *
 * 요청에 맞는 적절한 타입의 permission 객체를 제공해주는
 * 패키지 메인 클래스.
 *
 * ### app binding : xe.permission 으로 바인딩 되어 있음
 *
 * ### Usage
 * #### register
 * * 권한 등록
 * ```php
 *  $grant = new Xpressengine\Permission\Grant();
 *  $grant->set('access', 'guest');
 *  $grant->set('create', 'member');
 *  $grant->set('read', 'guest');
 *  $grant->set('update', 'group', ['group_id_1', 'group_id_2']);
 *  $grant->add('update', 'user', ['user_id_1', 'user_id_2']);
 *  $grant->set('delete', [
 *      'rating' => 'super',
 *      'group' => ['group_id_1', 'group_id_2'],
 *      'user' => ['user_id_1', 'user_id_2'],
 *  ]);
 *  // 저장소에 등록
 *  app('xe.permission')->register('menu.menu1', $grant);
 * ```
 *
 * * 제외
 * ```php
 *  // except 메서드를 사용해 특정 사용자의 권한을 제외시킬 수 있다.
 *  // except 는 사용자 아이디만 등록 되어진다.
 *  $grant->except('access', ['user_id_1', 'user_id_2']);
 * ```
 * #### define
 * permission 은 Illuminate\Auth\Access\Gate 를 통해 사용되어 진다.
 * 권한 검사를 하고자 하는 대상에 맞는 policy class 를 생성하여 등록시켜주어야 한다
 * ```php
 *  Gate::policy(Menu::class, MenuPolicy::class);
 * ```
 *
 * policy class 는 Xpressengine\Permission\Policy 를 상속받아 구현한다.
 * 이때 각 action 에 대한 메서드를 작성해야 하며 register 시 등록했던 permission 이름으로
 * 등록된 정보를 가져와야 한다.
 * ```php
 *  Class MenuItemPolicy extend Policy
 *  {
 *      public function access($user, $menu)
 *      {
 *          return $this->check($user, $this->get($menu->getNameForPermission()), 'access');
 *      }
 *  }
 * ```
 *
 * #### check
 * 권한에 대한 검사는 policy 에 정의된 메서드명과 같게 action 을 지정하여
 * 그 결과를 반환 받는다.
 * ```php
 *  if (Gate::denies('access', $menu)) {
 *      throw new AccessDeniesException();
 *  } else {
 *      ...
 *  }
 * ```
 *
 * #### non object check
 * 특정한 객체 없이 permission 이름만으로 권한 검사를 하고자 하는 경우 패키지내에
 * 존재하는 InstancePolicy 를 사용하여 해결할 수 있다.
 * ```php
 *  if (Gate::allows('create', new Instance('instance.name'))) {
 *      ...
 *  }
 * ```
 *
 * * Gate 사용에 대한 더 많은 정보를 원한다면 [laravel 메뉴얼](https://laravel.com/docs/5.1/authorization) 을 참고 한다.
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class PermissionHandler
{
    /**
     * Repository instance
     *
     * @var PermissionRepository
     */
    protected $repo;

    /**
     * PermissionHandler constructor.
     *
     * @param PermissionRepository $repo repository instance
     */
    public function __construct(PermissionRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get a permission from repository
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return Permission|null
     */
    public function get($name, $siteKey = 'default')
    {
        if ($permission = $this->repo->findByName($siteKey, $name)) {
            $this->setAncestor($permission);
        }

        return $permission;
    }

    /**
     * Get a permission from repository or generate when not exists
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return Permission|null
     */
    public function getOrNew($name, $siteKey = 'default')
    {
        if (!$permission = $this->get($name, $siteKey)) {
            $permission = $this->newItem();
            $permission->siteKey = $siteKey;
            $permission->name = $name;
        }

        $this->setAncestor($permission);

        return $permission;
    }

    /**
     * Get a permission from repository
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return Permission|null
     *
     * @deprecated since 3.0.0-beta.2
     */
    public function find($name, $siteKey = 'default')
    {
        return $this->get($name, $siteKey);
    }

    /**
     * Set permission's ancestor to permission
     *
     * @param Permission $permission permission instance
     * @return void
     */
    protected function setAncestor(Permission $permission)
    {
        $ancestors = $this->repo->fetchAncestor($permission->siteKey, $permission->name);
        usort($ancestors, function (Permission $a, Permission $b) {
            if ($a->getDepth() == $b->getDepth()) {
                return 0;
            }

            return $a->getDepth() > $b->getDepth() ? -1 : 1;
        });

        foreach ($ancestors as $ancestor) {
            $permission->addParent($ancestor);
        }
    }

    /**
     * Get a permission from repository or generate when not exists
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return Permission|null
     *
     * @deprecated since 3.0.0-beta.2
     */
    public function findOrNew($name, $siteKey = 'default')
    {
        return $this->getOrNew($name, $siteKey);
    }

    /**
     * Returns new permission instance
     *
     * @return Permission
     */
    public function newItem()
    {
        return new Permission();
    }

    /**
     * Register permission information
     *
     * @param string $name    permission name
     * @param Grant  $grant   grant instance
     * @param string $siteKey site key name
     * @return Permission
     */
    public function register($name, Grant $grant, $siteKey = 'default')
    {
        $permission = $this->getOrNew($name, $siteKey);

        if (strrpos($name, '.') !== false) {
            $pname = substr($name, 0, strrpos($name, '.'));
            if (!$this->repo->findByName($siteKey, $pname)) {
                throw new NoParentException(['name' => $name]);
            }
        }

        $permission->setGrant($grant);

        if ($permission->exists !== true) {
            return $this->repo->insert($permission);
        }

        return $this->repo->update($permission);
    }

    /**
     * Remove from repository
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return void
     */
    public function destroy($name, $siteKey = 'default')
    {
        if ($permission = $this->get($name, $siteKey)) {
            $this->repo->delete($permission);
        }
    }

    /**
     * 특정 대상이 포함된 하위 권한 정보를 가져와 캐싱 함
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return void
     *
     * @deprecated since 3.0.0-beta.2
     */
    public function loadBranch($name, $siteKey = 'default')
    {
        // it was legacy cache code
    }

    /**
     * Move entity hierarchy to new parent or root
     *
     * @param Permission  $permission permission instance
     * @param string|null $to         to prefix
     * @return void
     * @throws InvalidArgumentException
     * @throws NoParentException
     */
    public function move(Permission $permission, $to = null)
    {
        $toParent = $to !== null ? $this->repo->findByName($permission->siteKey, $to) : null;

        if (($to !== null && $toParent === null)
            || ($toParent !== null && $permission->type != $toParent->type)) {
            throw new InvalidArgumentException(['arg' => $to]);
        }

        $parent = $permission->getParent();

        if ($parent === null) {
            if ($permission->getDepth() !== 1) {
                throw new NoParentException(['name' => $permission->name]);
            }

            $this->repo->affiliate($permission, $to);
        } else {
            $this->repo->foster($permission, $to);
        }
    }
}
