<?php
/**
 * This file is a database repository.
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
     * @param  VirtualConnectionInterface  $conn  Connection instance
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Find a registered by type and name
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  target name
     *
     * @return Permission
     */
    public function findByName($siteKey, $name)
    {
        $row = $this->conn->table($this->table)
            ->where('site_key', $siteKey)
            ->where('name', $name)
            ->first();

        return $row ? $this->createItem((array) $row) : null;
    }

    /**
     * Insert register information
     *
     * @param  Permission  $item  permission instance
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

        return $this->createItem(
            array_merge($item->getAttributes(), ['id' => $id], $dates)
        );
    }

    /**
     * Update register information
     *
     * @param  Permission  $item  permission instance
     *
     * @return Permission
     */
    public function update(Permission $item)
    {
        $diff = $item->getDirty();

        $dates = [];

        if (count($diff) > 0) {
            $dates = ['updated_at' => $this->getNow()];

            $this->conn->table($this->table)
                ->where('id', $item->id)
                ->update(array_merge($diff, $dates));
        }

        return $this->createItem(
            array_merge($item->getOriginal(), $diff, $dates)
        );
    }

    /**
     * Delete register information
     *
     * @param  Permission  $item  permission instance
     *
     * @return int affecting statement
     */
    public function delete(Permission $item)
    {
        return $this->conn->table($this->table)
            ->where('id', $item->id)
            ->delete();
    }

    /**
     * Returns ancestor of item
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  target name
     * @return array
     */
    public function fetchAncestor($siteKey, $name)
    {
        $ancestorNames = $this->resolveAncestorNames($name);

        if (empty($ancestorNames) === true) {
            return [];
        }

        $rows = $this->conn->table($this->table)
            ->where('site_key', $siteKey)
            ->whereIn('name', $ancestorNames)
            ->get();

        $items = [];

        foreach ($rows as $row) {
            $items[] = $this->createItem((array) $row);
        }

        return $items;
    }

    /**
     * Returns descendant of item
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  target name
     * @return array
     */
    public function fetchDescendant($siteKey, $name)
    {
        $rows = $this->conn->table($this->table)
            ->where('site_key', $siteKey)
            ->where('name', 'like', $name.'.%')
            ->where('name', '<>', $name)->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createItem((array) $row);
        }

        return $items;
    }

    /**
     * Parent Changing with descendant
     *
     * @param  Permission  $item  permission instance
     * @param  string  $to  parent name
     *
     * @return void
     */
    public function foster(Permission $item, $to)
    {
        $query = $this->conn->table($this->table)
            ->where('site_key', $item->site_key)
            ->where(
                function ($query) use ($item) {
                    $query->where('name', $item->name)
                        ->orWhere('name', 'like', $item->name.'.%');
                }
            );

        $arr = explode('.', $item->name);
        array_pop($arr);
        $from = implode('.', $arr);

        if ($to === null) {
            $query->update([
                'name' => $this->conn->raw(sprintf(
                    'substr(`name`, length(%s) + 2)',
                    $this->quoteSqlString($from)
                ))
            ]);

            return;
        }

        $query->update([
            'name' => $this->conn->raw(sprintf(
                'concat(%s, substr(`name`, length(%s) + 1))',
                $this->quoteSqlString($to),
                $this->quoteSqlString($from)
            ))
        ]);
    }

    /**
     * affiliated to another registered
     *
     * @param  Permission  $item  permission instance
     * @param  string  $to  parent name
     *
     * @return void
     */
    public function affiliate(Permission $item, $to)
    {
        if ($to === null) {
            return;
        }

        $this->conn->table($this->table)
            ->where('site_key', $item->site_key)
            ->where(function ($query) use ($item) {
                $query->where('name', $item->name)
                    ->orWhere('name', 'like', $item->name.'.%');
            })
            ->update([
                'name' => $this->conn->raw(sprintf(
                    'concat(%s, %s, `name`)',
                    $this->quoteSqlString($to),
                    $this->quoteSqlString('.')
                ))
            ]);

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
     * @param  array  $attributes  attributes array
     *
     * @return Permission
     */
    protected function createItem(array $attributes)
    {
        $item = new Permission($attributes);
        $item->exists = true;

        return $item;
    }

    /**
     * Calculates the list of ancestor names for the current name.
     *
     * @param  string  $name  target name
     *
     * @return array
     */
    private function resolveAncestorNames($name)
    {
        $segments = explode('.', $name);
        array_pop($segments);

        $ancestorNames = [];
        $currentSegments = [];

        foreach ($segments as $segment) {
            $currentSegments[] = $segment;
            $ancestorNames[] = implode('.', $currentSegments);
        }

        return $ancestorNames;
    }

    /**
     * Escapes string literals included in a raw SQL expression according to SQL syntax.
     *
     * Used only for strings inside UPDATE expressions where Query Builder bindings cannot be used.
     *
     * @param  string  $value  Value to wrap as an SQL string literal
     *
     * @return string
     */
    private function quoteSqlString($value)
    {
        return sprintf("'%s'", str_replace(
            ['\\', "'"],
            ['\\\\', "''"],
            $value
        ));
    }
}
