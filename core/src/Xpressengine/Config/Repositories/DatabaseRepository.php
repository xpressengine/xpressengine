<?php
/**
 * Database Repository class
 *
 * PHP version 7
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Config\Repositories;

use Xpressengine\Config\ConfigRepository;
use XpressEngine\Database\VirtualConnectionInterface;
use Xpressengine\Config\ConfigEntity;

/**
 * Handles database input and output.
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DatabaseRepository implements ConfigRepository
{
    /**
     * using DB table name
     *
     * @var string
     */
    protected $table = 'config';

    /**
     * DB connection instance
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * constructor
     *
     * @param  VirtualConnectionInterface  $conn  DB connection instance
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * search getter
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  the name
     *
     * @return ConfigEntity
     */
    public function find($siteKey, $name)
    {
        $row = $this->conn->table($this->table)
            ->where('site_key', $siteKey)
            ->where('name', $name)
            ->first();

        if ($row !== null) {
            return $this->createModel((array) $row);
        }

        return null;
    }

    /**
     * search ancestors getter
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  the name
     *
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
            $items[] = $this->createModel((array) $row);
        }

        return $items;
    }

    /**
     * search descendants getter
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  the name
     *
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
            $items[] = $this->createModel((array) $row);
        }

        return $items;
    }

    /**
     * save
     *
     * @param  ConfigEntity  $config  config object
     *
     * @return ConfigEntity
     */
    public function save(ConfigEntity $config)
    {
        $exists = $this->find($config->site_key, $config->name);

        if ($exists === null) {
            return $this->insert($config);
        }

        return $this->update($config);
    }

    /**
     * clear all just descendants vars
     *
     * @param  ConfigEntity  $config  config object
     * @param  array  $excepts  target to the excepting
     *
     * @return void
     */
    public function clearLike(ConfigEntity $config, $excepts = [])
    {
        $query = $this->conn->table($this->table)
            ->where('site_key', $config->site_key)
            ->where('name', 'like', $config->name.'%')
            ->where('name', '<>', $config->name);

        foreach ($excepts as $except) {
            $query->where('name', 'not like', $except.'%');
        }

        $query->update(
            ['vars' => json_encode([])]
        );
    }

    /**
     * remove
     *
     * @param  string  $siteKey  site key
     * @param  string  $name  the name
     *
     * @return void
     */
    public function remove($siteKey, $name)
    {
        $this->conn->table($this->table)
            ->where('site_key', $siteKey)
            ->where(
                function ($query) use ($name) {
                    $query->where('name', 'like', $name.'.%')
                        ->orWhere('name', $name);
                }
            )->delete();
    }

    /**
     * insert
     *
     * @param  ConfigEntity  $config  config object
     *
     * @return ConfigEntity
     */
    protected function insert(ConfigEntity $config)
    {
        $this->conn->table($this->table)->insert(
            $config->getAttributes()
        );

        return $this->createModel(
            $config->getAttributes()
        );
    }

    /**
     * update
     *
     * @param  ConfigEntity  $config  config object
     *
     * @return ConfigEntity
     */
    protected function update(ConfigEntity $config)
    {
        $diff = $config->getDirty();

        if (count($diff) > 0) {
            $this->conn->table($this->table)
                ->where('site_key', $config->site_key)
                ->where('name', $config->name)
                ->update($diff);
        }

        return $this->createModel(
            array_merge($config->getOriginal(), $diff)
        );
    }

    /**
     * Parent Changing with descendant
     *
     * @param  ConfigEntity  $config  config object
     * @param  string|null  $to  to config prefix
     *
     * @return void
     */
    public function foster(ConfigEntity $config, $to = null)
    {
        $query = $this->conn->table($this->table)
            ->where('site_key', $config->site_key)
            ->where(
                function ($query) use ($config) {
                    $query->where('name', $config->name)
                        ->orWhere('name', 'like', $config->name.'.%');
                }
            );

        $arr = explode('.', $config->name);
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
     * affiliated to another config
     *
     * @param  ConfigEntity  $config  config object
     * @param  string|null  $to  parent name
     *
     * @return void
     */
    public function affiliate(ConfigEntity $config, $to = null)
    {
        if ($to === null) {
            return;
        }

        $this->conn->table($this->table)
            ->where('site_key', $config->site_key)
            ->where(function ($query) use ($config) {
                $query->where('name', $config->name)
                    ->orWhere('name', 'like', $config->name.'.%');
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
     * make a new object
     *
     * @param  array  $attributes  raw data
     *
     * @return ConfigEntity
     */
    protected function createModel(array $attributes)
    {
        return new ConfigEntity($attributes);
    }

    /**
     * Calculates the list of ancestor names for the current name.
     *
     * @param  string  $name  config name
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
