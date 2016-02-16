<?php
/**
 * This file is a registered information repository.
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

use Xpressengine\Database\VirtualConnectionInterface;

/**
 * register 된 정보 데이터베이스에 저장, 제공 함.
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PermissionRepository
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
     * @param string $type    permission type
     * @param string $name    target name
     *
     * @return Registered
     */
    public function findByTypeAndName($siteKey, $type, $name)
    {
        $row = $this->conn->table($this->table)
            ->where('siteKey', $siteKey)
            ->where('name', $name)
            ->where('type', $type)
            ->first();

        if ($row !== null) {
            return $this->createItem((array)$row);
        }

        return null;
    }

    /**
     * Insert register information
     *
     * @param Registered $item registered instance
     *
     * @return Registered
     */
    public function insert(Registered $item)
    {
        $now = date('Y-m-d H:i:s');
        $dates = [
            'createdAt' => $now,
            'updatedAt' => $now,
        ];

        $id = $this->conn->table($this->table)->insertGetId(
            array_merge($item->getAttributes(), $dates)
        );

        return $this->createItem(array_merge($item->getAttributes(), ['id' => $id], $dates));
    }

    /**
     * Update register information
     *
     * @param Registered $item registered instance
     *
     * @return Registered
     */
    public function update(Registered $item)
    {
        $diff = $item->getDirty();

        $dates = [];
        if (count($diff) > 0) {
            $dates = ['updatedAt' => date('Y-m-d H:i:s')];
            $this->conn->table($this->table)->where('id', $item->id)->update(array_merge($diff, $dates));
        }

        return $this->createItem(array_merge($item->getOriginal(), $diff, $dates));
    }

    /**
     * Delete register information
     *
     * @param Registered $item registered instance
     *
     * @return int affecting statement
     */
    public function delete(Registered $item)
    {
        return $this->conn->table($this->table)->where('id', $item->id)->delete();
    }

    /**
     * Returns list of registered
     *
     * @param string $siteKey site key
     * @param string $type    permission type
     *
     * @return Registered[]
     */
    public function fetchByType($siteKey, $type)
    {
        $rows = $this->conn->table($this->table)
            ->where('siteKey', $siteKey)
            ->where('type', $type)
            ->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createItem((array)$row);
        }

        return $items;
    }

    /**
     * search ancestors getter
     *
     * @param Registered $item item object
     *
     * @return array
     */
    public function fetchAncestor(Registered $item)
    {
        $rows = $this->conn->table($this->table)
            ->where('siteKey', $item->siteKey)
            ->where('type', $item->type)
            ->whereRaw("'" . $item->name . "' like concat(`name`, '.', '%')")
            ->where('name', '<>', $item->name)->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createItem((array)$row);
        }

        return $items;
    }

    /**
     * Parent Changing with descendant
     *
     * @param Registered $item registered object
     * @param string     $to   to registered prefix
     *
     * @return void
     */
    public function foster(Registered $item, $to)
    {
        $query = $this->conn->table($this->table)
            ->where('siteKey', $item->siteKey)
            ->where('type', $item->type)
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
     * @param Registered $item registered object
     * @param string     $to   parent name
     *
     * @return void
     */
    public function affiliate(Registered $item, $to)
    {
        if ($to !== null) {
            $this->conn->table($this->table)
                ->where('siteKey', $item->siteKey)
                ->where('type', $item->type)
                ->where(function ($query) use ($item) {
                    $query->where('name', $item->name)
                        ->orWhere('name', 'like', $item->name . '.%');
                })
                ->update(['name' => $this->conn->raw("concat('{$to}', '.', `name`)")]);
        }
    }

    /**
     * Create a new registered object instance
     *
     * @param array $attributes attributes array
     *
     * @return Registered
     */
    protected function createItem(array $attributes)
    {
        return new Registered($attributes);
    }
}
