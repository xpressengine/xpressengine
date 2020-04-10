<?php
/**
 * This file is the handler for permission.
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

use Xpressengine\Permission\Exceptions\InvalidArgumentException;
use Xpressengine\Permission\Exceptions\NoParentException;

/**
 * Class PermissionHandler
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
            $permission->site_key = $siteKey;
            $permission->name = $name;
        }

        $this->setAncestor($permission);

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
        $ancestors = $this->repo->fetchAncestor($permission->site_key, $permission->name);
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
        $toParent = $to !== null ? $this->repo->findByName($permission->site_key, $to) : null;

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
