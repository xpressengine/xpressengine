<?php
/**
 * This file is a database repository.
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

use Carbon\Carbon;
use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Permission\Permission;
use Xpressengine\Permission\PermissionRepository;

/**
 * Class DatabaseRepository
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DatabaseRepository implements PermissionRepository
{
    /**
     * Connection instance
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * Constructor
     *
     * @param VirtualConnectionInterface $conn Connection instance
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Find a registered by type and name
     *
     * @param string $siteKey site key
     * @param string $name    target name
     *
     * @return Permission
     */
    public function findByName($siteKey, $name)
    {
        $row = $this->conn->table($this->table)
            ->where('site_key', $siteKey)
            ->where('name', $name)
            ->first();

        return $row ? $this->createItem((array)$row) : null;
    }

    /**
     * Insert register information
     *
     * @param Permission $item permission instance
     *
     * @return Permission
     */
    public function insert(Permission $item)
    {
        $now = $this->getNow();
        $dates = [
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $id = $this->conn->table($this->table)->insertGetId(
            array_merge($item->getAttributes(), $dates)
        );

        return $this->createItem(array_merge($item->getAttributes(), ['id' => $id], $dates));
    }

    /**
     * Update register information
     *
     * @param Permission $item permission instance
     *
     * @return Permission
     */
    public function update(Permission $item)
    {
        $diff = $item->getDirty();

        $dates = [];
        if (count($diff) > 0) {
            $dates = ['updated_at' => $this->getNow()];
            $this->conn->table($this->table)->where('id', $item->id)->update(array_merge($diff, $dates));
        }

        return $this->createItem(array_merge($item->getOriginal(), $diff, $dates));
    }

    /**
     * Delete register information
     *
     * @param Permission $item permission instance
     *
     * @return int affecting statement
     */
    public function delete(Permission $item)
    {
        return $this->conn->table($this->table)->where('id', $item->id)->delete();
    }

    /**
     * Returns ancestor of item
     *
     * @param string $siteKey site key
     * @param string $name    target name
     * @return array
     */
    public function fetchAncestor($siteKey, $name)
    {
        $rows = $this->conn->table($this->table)
            ->where('site_key', $siteKey)
            ->whereRaw("'" . $name . "' like concat(`name`, '.', '%')")
            ->where('name', '<>', $name)->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createItem((array)$row);
        }

        return $items;
    }

    /**
     * Returns descendant of item
     *
     * @param string $siteKey site key
     * @param string $name    target name
     * @return array
     */
    public function fetchDescendant($siteKey, $name)
    {
        $rows = $this->conn->table($this->table)
            ->where('site_key', $siteKey)
            ->where('name', 'like', $name . '.%')
            ->where('name', '<>', $name)->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createItem((array)$row);
        }

        return $items;
    }

    /**
     * Parent Changing with descendant
     *
     * @param Permission $item permission instance
     * @param string     $to   parent name
     *
     * @return void
     */
    public function foster(Permission $item, $to)
    {
        $query = $this->conn->table($this->table)
            ->where('site_key', $item->siteKey)
            ->where(function ($query) use ($item) {
                $query->where('name', $item->name)
                    ->orWhere('name', 'like', $item->name . '.%');
            });

        $arr = explode('.', $item->name);
        array_pop($arr);
        $from = implode('.', $arr);

        if ($to === null) {
            $query->update(['name' => $this->conn->raw("substr(`name`, length('{$from}') + 2)")]);
        } else {
            $query->update(['name' => $this->conn->raw("concat('{$to}', substr(`name`, length('{$from}') + 1))")]);
        }
    }

    /**
     * affiliated to another registered
     *
     * @param Permission $item permission instance
     * @param string     $to   parent name
     *
     * @return void
     */
    public function affiliate(Permission $item, $to)
    {
        if ($to !== null) {
            $this->conn->table($this->table)
                ->where('site_key', $item->siteKey)
                ->where(function ($query) use ($item) {
                    $query->where('name', $item->name)
                        ->orWhere('name', 'like', $item->name . '.%');
                })
                ->update(['name' => $this->conn->raw("concat('{$to}', '.', `name`)")]);
        }
    }

    /**
     * Now datetime string
     *
     * @return string
     */
    public function getNow()
    {
        return Carbon::now()->format('Y-m-d H:i:s');
    }

    /**
     * Create a new registered object instance
     *
     * @param array $attributes attributes array
     *
     * @return Permission
     */
    protected function createItem(array $attributes)
    {
        $item = new Permission($attributes);
        $item->exists = true;

        return $item;
    }
}
