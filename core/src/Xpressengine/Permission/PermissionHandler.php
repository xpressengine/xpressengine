<?php
/**
 * This file is the handler for permission.
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
namespace Xpressengine\Permission;

use Xpressengine\Permission\Exceptions\InvalidArgumentException;
use Xpressengine\Permission\Exceptions\NoParentException;

/**
 * Class PermissionHandler
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
     * The loaded permission instance
     *
     * @var array
     */
    protected $loaded = [];

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
     * Get a permission
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return Permission|null
     */
    public function get($name, $siteKey = 'default')
    {
        if (!$this->load($siteKey, $name)) {
            return null;
        }

        return $this->loaded[$this->makeKeyForLoaded($siteKey, $name)];
    }

    /**
     * Load permission from repository
     *
     * @param string $siteKey site key name
     * @param string $name    permission name
     * @return bool
     */
    protected function load($siteKey, $name)
    {
        $loadedKey = $this->makeKeyForLoaded($siteKey, $name);

        if (!isset($this->loaded[$loadedKey])) {
            if (!$permission = $this->find($name, $siteKey)) {
                return false;
            }

            $this->loaded[$loadedKey] = $permission;
        }

        return true;
    }

    /**
     * Make key for loaded property
     *
     * @param string $siteKey site key name
     * @param string $name    permission name
     * @return string
     */
    protected function makeKeyForLoaded($siteKey, $name)
    {
        return $siteKey .'-'. $name;
    }

    /**
     * Get a permission from repository
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return Permission|null
     */
    public function find($name, $siteKey = 'default')
    {
        if ($permission = $this->repo->findByName($siteKey, $name)) {
            $this->setAncestor($permission);
        }

        return $permission;
    }

    /**
     * Set permission's ancestor to permission
     *
     * @param Permission $permission permission instance
     * @return void
     */
    protected function setAncestor(Permission $permission)
    {
        $ancestors = $this->repo->fetchAncestor($permission);
        usort($ancestors, function (Permission $a, Permission $b) {
            if ($a->getDepth() == $b->getDepth()) {
                return 0;
            }

            return $a->getDepth() > $b->getDepth() ? -1 : 1;
        });

        foreach ($ancestors as $ancestor) {
            $permission->addParent($ancestor);

            // 각각의 record 를 loaded 에 캐싱 함
            $loadedKey = $this->makeKeyForLoaded($ancestor->siteKey, $ancestor->name);
            $this->loaded[$loadedKey] = $ancestor;
        }

//        $permissions = array_merge($ancestors, [$permission]);
//        $parent = null;
//        foreach ($permissions as $idx => $permission) {
//            if ($idx > 0) {
//                $permission->addParent($parent);
//            }
//
//            $parent = $permission;
//        }
    }

    /**
     * Get a permission from repository or generate when not exists
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return Permission|null
     */
    public function findOrNew($name, $siteKey = 'default')
    {
        if (!$permission = $this->find($name, $siteKey)) {
            $permission = $this->newItem();
            $permission->siteKey = $siteKey;
            $permission->name = $name;
        }

        $this->setAncestor($permission);

        return $permission;
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
        $permission = $this->findOrNew($name, $siteKey);
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
        if ($permission = $this->find($name, $siteKey)) {
            $this->repo->delete($permission);
        }
    }

    /**
     * 특정 대상이 포함된 하위 권한 정보를 가져와 캐싱 함
     *
     * @param string $name    permission name
     * @param string $siteKey site key name
     * @return void
     */
    public function loadBranch($name, $siteKey = 'default')
    {
        if (!$this->load($siteKey, $name)) {
            return;
        }

        $permission = $this->loaded[$this->makeKeyForLoaded($siteKey, $name)];
        $descendants = $this->repo->fetchDescendant($permission);

        usort($descendants, function (Permission $a, Permission $b) {
            if ($a->getDepth() == $b->getDepth()) {
                return 0;
            }

            return $a->getDepth() < $b->getDepth() ? -1 : 1;
        });

        foreach ($descendants as $descendant) {
            $ascKey = $this->makeKeyForLoaded(
                $descendant->siteKey,
                substr($descendant->name, 0, strrpos($descendant->name, '.'))
            );
            $descendant->addParent($this->loaded[$ascKey]);

            // 각각의 record 를 loaded 에 캐싱 함
            $loadedKey = $this->makeKeyForLoaded($descendant->siteKey, $descendant->name);
            $this->loaded[$loadedKey] = $descendant;
        }
    }

    /**
     * 여러개의 대상을 지정해 권한 정보를 가져와 캐싱 함
     *
     * @param string|array $names   permission name
     * @param string       $siteKey site key name
     * @return void
     */
    public function loadEach($names, $siteKey = 'default')
    {
        $names = !is_array($names) ? [$names] : $names;
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
                throw new NoParentException();
            }

            $this->repo->affiliate($permission, $to);
        } else {
            $this->repo->foster($permission, $to);
        }
    }
}
