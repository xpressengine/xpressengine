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
 * Class PermissionHandler
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
