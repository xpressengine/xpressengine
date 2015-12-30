<?php
/**
 * This file is category item repository class.
 *
 * PHP version 5
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Category;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Support\Tree\ClosureTableTrait;

/**
 * 카테고리를 구성하는 각 아이템의 저장소.
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CategoryItemRepository
{
    use ClosureTableTrait;

    /**
     * Node table name
     *
     * @var string
     */
    protected $nodeTable = 'category_item';

    /**
     * Hierarchy table
     *
     * @var string
     */
    protected $hierarchyTable = 'category_item_hierarchy';

    /**
     * Used table
     *
     * @var string
     */
    protected $usedTable = 'category_item_used';

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
     * Get a item object
     *
     * @param int $id item id
     * @return null|CategoryItemEntity
     */
    public function find($id)
    {
        $row = $this->conn->table($this->nodeTable)->where('id', $id)->first();

        if ($row !== null) {
            return $this->createNodeModel((array)$row);
        }

        return null;
    }

    /**
     * Insert an item
     *
     * @param CategoryItemEntity $item item object
     * @return CategoryItemEntity
     */
    public function insert(CategoryItemEntity $item)
    {
        $attributes = $item->getAttributes();
        $now = date('Y-m-d H:i:s');

        $attributes = array_merge($attributes, [
            'createdAt' => $now,
            'updatedAt' => $now,
        ]);

        $id = $this->conn->table($this->nodeTable)->insertGetId($attributes);

        return $this->createNodeModel(array_merge($attributes, compact('id')));
    }

    /**
     * Update an item
     *
     * @param CategoryItemEntity $item item object
     * @return CategoryItemEntity
     */
    public function update(CategoryItemEntity $item)
    {
        $diff = $item->diff();

        $updatedAt = [];
        if (count($diff) > 0) {
            $updatedAt = ['updatedAt' => date('Y-m-d H:i:s')];
            $this->conn->table($this->nodeTable)
                ->where('id', $item->id)
                ->update(array_merge($diff, $updatedAt));
        }

        return $this->createNodeModel(array_merge($item->getOriginal(), $diff, $updatedAt));
    }

    /**
     * Delete an item
     *
     * @param CategoryItemEntity $item item object
     * @return int
     */
    public function delete(CategoryItemEntity $item)
    {
        return $this->conn->table($this->nodeTable)->where('id', $item->id)->delete();
    }

    /**
     * Get top level items
     *
     * @param int $categoryId category id
     * @return CategoryItemEntity[]
     */
    public function fetchProgenitor($categoryId)
    {
        $rows = $this->conn->table($this->nodeTable)
            ->whereIn('id', function ($query) use ($categoryId) {
                $query->select('descendant')
                    ->from($this->hierarchyTable)
                    ->whereIn('ancestor', function ($query) use ($categoryId) {
                        $query->select('id')
                            ->from($this->nodeTable)
                            ->where('categoryId', $categoryId);
                    })
                    ->groupBy('descendant')
                    ->havingRaw('count(*) = 1');
            })->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createNodeModel((array)$row);
        }

        return $items;
    }

    /**
     * Get an item's descendant count
     *
     * @param CategoryItemEntity $top   std item object for counting
     * @param int                $depth search depth value
     * @return int
     */
    public function count(CategoryItemEntity $top, $depth = 0)
    {
        $query = $this->conn->table($this->nodeTable)
            ->leftJoin(
                $this->hierarchyTable,
                $this->nodeTable . '.id',
                '=',
                $this->hierarchyTable . '.ancestor'
            );

        $query->where($this->hierarchyTable . '.ancestor', $top->id);

        if ($depth > 0) {
            $query->where($this->hierarchyTable . '.depth', '<=', $depth);
        }

        $query->where($this->hierarchyTable . '.depth', '!=', 0);

        return $query->count();
    }

    /**
     * Check target used category item
     *
     * @param string             $targetId target id
     * @param CategoryItemEntity $item     item object
     * @return bool
     */
    public function existsUsed($targetId, CategoryItemEntity $item)
    {
        return $this->conn->table($this->usedTable)
            ->where('targetId', $targetId)
            ->where('itemId', $item->id)
            ->exists();
    }

    /**
     * Insert used record
     *
     * @param string             $targetId target id
     * @param CategoryItemEntity $item     item object
     * @return bool
     */
    public function insertUsed($targetId, CategoryItemEntity $item)
    {
        return $this->conn->table($this->usedTable)->insert([
            'targetId' => $targetId,
            'itemId' => $item->id,
            'createdAt' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Delete used record
     *
     * @param string             $targetId target id
     * @param CategoryItemEntity $item     item object
     * @return int affecting statement
     */
    public function deleteUsed($targetId, CategoryItemEntity $item)
    {
        return $this->conn->table($this->usedTable)
            ->where('targetId', $targetId)
            ->where('itemId', $item->id)
            ->delete();
    }

    /**
     * Item objects of a target used
     *
     * @param string $targetId target id
     * @return array of item object
     */
    public function hasMany($targetId)
    {
        $rows = $this->conn->table($this->usedTable . ' as used')
            ->leftJoin($this->nodeTable . ' as node', 'used.itemId', '=', 'node.id')
            ->where('used.targetId', $targetId)
            ->select(['node.*'])
            ->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createNodeModel((array)$row);
        }

        return $items;
    }

    /**
     * Returns target id list by item id list
     *
     * @param array $ids item ids
     * @return array
     */
    public function fetchTargetIdsByIds(array $ids)
    {
        $rows = $this->conn->table($this->usedTable)->whereIn('itemId', $ids)->get();

        $targetIds = [];
        foreach ($rows as $row) {
            $row = (array)$row;
            $targetIds[] = $row['targetId'];
        }

        return $targetIds;
    }

    /**
     * Create item object from attributes
     *
     * @param array $attributes object attributes
     * @return CategoryItemEntity
     */
    protected function createNodeModel(array $attributes)
    {
        return new CategoryItemEntity($attributes);
    }
}
