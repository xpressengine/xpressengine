<?php
/**
 * This file is a memory decorator.
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
namespace Xpressengine\Permission\Repositories;

use Xpressengine\Permission\Permission;
use Xpressengine\Permission\PermissionRepository;

/**
 * Class MemoryDecorator
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MemoryDecorator implements PermissionRepository
{
    /**
     * PermissionRepository instance
     *
     * @var PermissionRepository
     */
    protected $repo;

    /**
     * Data bag
     *
     * @var array
     */
    protected $bag = [];

    /**
     * MemoryDecorator constructor.
     *
     * @param PermissionRepository $repo PermissionRepository instance
     */
    public function __construct(PermissionRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Find a registered by type and name
     *
     * @param string $siteKey site key
     * @param string $name    target name
     * @return Permission
     */
    public function findByName($siteKey, $name)
    {
        $key = $this->getKey($siteKey, $name);

        if (!isset($this->bag[$key])) {
            if ($perm = $this->repo->findByName($siteKey, $name)) {
                $this->bag[$key] = $perm;
            } else {
                return null;
            }
        }

        return $this->bag[$key];
    }

    /**
     * Insert register information
     *
     * @param Permission $item permission instance
     * @return Permission
     */
    public function insert(Permission $item)
    {
        $item = $this->repo->insert($item);
        $this->bag[$this->getKey($item->siteKey, $item->name)] = $item;

        return $item;
    }

    /**
     * Update register information
     *
     * @param Permission $item permission instance
     * @return Permission
     */
    public function update(Permission $item)
    {
        $item = $this->repo->update($item);
        $this->bag[$this->getKey($item->siteKey, $item->name)] = $item;

        return $item;
    }

    /**
     * Delete register information
     *
     * @param Permission $item permission instance
     * @return int affecting statement
     */
    public function delete(Permission $item)
    {
        unset($this->bag[$this->getKey($item->siteKey, $item->name)]);

        return $this->repo->delete($item);
    }

    /**
     * Returns ancestor of item
     *
     * @param Permission $item permission instance
     * @return array
     */
    public function fetchAncestor(Permission $item)
    {
        return $this->repo->fetchAncestor($item);
    }

    /**
     * Returns descendant of item
     *
     * @param Permission $item permission instance
     * @return array
     */
    public function fetchDescendant(Permission $item)
    {
        return $this->repo->fetchDescendant($item);
    }

    /**
     * Parent Changing with descendant
     *
     * @param Permission $item permission instance
     * @param string     $to   parent name
     * @return void
     */
    public function foster(Permission $item, $to)
    {
        unset($this->bag[$this->getKey($item->siteKey, $item->name)]);

        $this->repo->foster($item, $to);
    }

    /**
     * affiliated to another registered
     *
     * @param Permission $item permission instance
     * @param string     $to   parent name
     * @return void
     */
    public function affiliate(Permission $item, $to)
    {
        unset($this->bag[$this->getKey($item->siteKey, $item->name)]);

        $this->repo->affiliate($item, $to);
    }

    /**
     * The string for array key
     *
     * @param string $siteKey site key
     * @param string $name    permission name
     * @return string
     */
    protected function getKey($siteKey, $name)
    {
        return $siteKey . '-' . $name;
    }
}
