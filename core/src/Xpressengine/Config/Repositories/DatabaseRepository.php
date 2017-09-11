<?php
/**
 * Database Repository class
 *
 * PHP version 5
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Config\Repositories;

use Xpressengine\Config\ConfigRepository;
use XpressEngine\Database\VirtualConnectionInterface;
use Xpressengine\Config\ConfigEntity;

/**
 * DB 에 자료를 입출력 하는 역할을 담당
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
     * @param VirtualConnectionInterface $conn DB connection instance
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * search getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     *
     * @return ConfigEntity
     */
    public function find($siteKey, $name)
    {
        $row = $this->conn->table($this->table)->where('site_key', $siteKey)->where('name', $name)->first();

        if ($row !== null) {
            return $this->createModel((array)$row);
        }

        return null;
    }

    /**
     * search ancestors getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     *
     * @return array
     */
    public function fetchAncestor($siteKey, $name)
    {
        $rows = $this->conn->table($this->table)
            ->where('site_key', $siteKey)
            ->whereRaw("'{$name}' like concat(`name`, '.', '%')")
            ->where('name', '<>', $name)->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createModel((array)$row);
        }

        return $items;
    }

    /**
     * search descendants getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     *
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
            $items[] = $this->createModel((array)$row);
        }

        return $items;
    }

    /**
     * save
     *
     * @param ConfigEntity $config config object
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
     * @param ConfigEntity $config  config object
     * @param array        $excepts target to the except
     *
     * @return void
     */
    public function clearLike(ConfigEntity $config, $excepts = [])
    {
        $query = $this->conn->table($this->table)
            ->where('site_key', $config->site_key)
            ->where('name', 'like', $config->name . '%')
            ->where('name', '<>', $config->name);

        foreach ($excepts as $except) {
            $query->where('name', 'not like', $except . '%');
        }

        $query->update(
            ['vars' => json_encode([])]
        );
    }

    /**
     * remove
     *
     * @param string $siteKey site key
     * @param string $name    the name
     *
     * @return void
     */
    public function remove($siteKey, $name)
    {
        $this->conn->table($this->table)
            ->where('site_key', $siteKey)
            ->where(function ($query) use ($name) {
                $query->where('name', 'like', $name . '.%')
                    ->orWhere('name', $name);
            })->delete();
    }

    /**
     * insert
     *
     * @param ConfigEntity $config config object
     *
     * @return ConfigEntity
     */
    protected function insert(ConfigEntity $config)
    {
        $this->conn->table($this->table)->insert($config->getAttributes());

        return $this->createModel($config->getAttributes());
    }

    /**
     * update
     *
     * @param ConfigEntity $config config object
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

        return $this->createModel(array_merge($config->getOriginal(), $diff));
    }

    /**
     * Parent Changing with descendant
     *
     * @param ConfigEntity $config config object
     * @param string|null  $to     to config prefix
     *
     * @return void
     */
    public function foster(ConfigEntity $config, $to = null)
    {
        $query = $this->conn->table($this->table)
            ->where('site_key', $config->site_key)
            ->where(function ($query) use ($config) {
                $query->where('name', $config->name)
                    ->orWhere('name', 'like', $config->name . '.%');
            });

        $arr = explode('.', $config->name);
        array_pop($arr);
        $from = implode('.', $arr);

        if ($to === null) {
            $query->update(['name' => $this->conn->raw("substr(`name`, length('{$from}') + 2)")]);
        } else {
            $query->update(['name' => $this->conn->raw("concat('{$to}', substr(`name`, length('{$from}') + 1))")]);
        }
    }

    /**
     * affiliated to another config
     *
     * @param ConfigEntity $config config object
     * @param string|null  $to     parent name
     *
     * @return void
     */
    public function affiliate(ConfigEntity $config, $to = null)
    {
        if ($to !== null) {
            $this->conn->table($this->table)
                ->where('site_key', $config->site_key)
                ->where(function ($query) use ($config) {
                    $query->where('name', $config->name)
                        ->orWhere('name', 'like', $config->name . '.%');
                })
                ->update(['name' => $this->conn->raw("concat('{$to}', '.', `name`)")]);
        }
    }

    /**
     * make new object
     *
     * @param array $attributes raw data
     *
     * @return ConfigEntity
     */
    protected function createModel(array $attributes)
    {
        return new ConfigEntity($attributes);
    }
}
