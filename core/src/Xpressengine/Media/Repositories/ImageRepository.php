<?php
/**
 * This file is Image repository
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Media\Repositories;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Media\Meta;
use Xpressengine\Database\BuildWhereTrait;

/**
 * image 데이터 저장소
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ImageRepository
{
    use BuildWhereTrait;

    /**
     * VirtualConnection instance
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'files_image';

    /**
     * Constructor
     *
     * @param VirtualConnectionInterface $conn VirtualConnection instance
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Find a meta data
     *
     * @param string $id file id
     * @return null|Meta
     */
    public function find($id)
    {
        $row = $this->conn->table($this->table)->where('id', $id)->first();

        if ($row !== null) {
            return $this->createItem((array)$row);
        }

        return null;
    }

    /**
     * Find a meta data by option
     *
     * @param array $options where clause
     * @return null|Meta
     */
    public function findByOption(array $options)
    {
        $query = $this->conn->table($this->table);
        foreach ($options as $column => $value) {
            $query->where($column, $value);
        }

        $row = $query->first();

        if ($row !== null) {
            return $this->createItem((array)$row);
        }

        return null;
    }

    /**
     * Get meta item list
     *
     * @param array $wheres where clause
     * @return Meta[]
     */
    public function fetch(array $wheres)
    {
        $rows = $this->buildWhere($this->conn->table($this->table), $wheres)->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createItem((array)$row);
        }

        return $items;
    }

    /**
     * Insert
     *
     * @param Meta $meta meta instance
     * @return null|Meta
     */
    public function insert(Meta $meta)
    {
        $this->conn->table($this->table)->insert($meta->getAttributes());

        return $this->find($meta->id);
    }

    /**
     * Delete
     *
     * @param Meta $meta meta instance
     * @return int
     */
    public function delete(Meta $meta)
    {
        return $this->conn->table($this->table)->where('id', $meta->id)->delete();
    }

    /**
     * Delete by origin
     *
     * @param string $originId origin id
     * @return int
     */
    public function deleteByOriginId($originId)
    {
        return $this->conn->table($this->table)->where('originId', $originId)->delete();
    }

    /**
     * Create item
     *
     * @param array $attributes attributes
     * @return Meta
     */
    protected function createItem(array $attributes)
    {
        return new Meta($attributes);
    }
}
