<?php
/**
 * This file is category repository class.
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

use Xpressengine\Database\VirtualConnection;

/**
 * 여러단어들로 구성된 카테고리들의 저장소.
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CategoryRepository
{
    /**
     * Connection instance
     *
     * @var ConnectionInterface
     */
    protected $conn;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'category_group';

    /**
     * Constructor
     *
     * @param VirtualConnection $conn Connection instance
     */
    public function __construct(VirtualConnection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get a category object
     *
     * @param int $id category id
     * @return null|CategoryEntity
     */
    public function find($id)
    {
        $row = $this->conn->table($this->table)->where('id', $id)->first();

        if ($row !== null) {
            return $this->createEntity((array)$row);
        }

        return null;
    }

    /**
     * Insert category
     *
     * @param CategoryEntity $category category object
     * @return CategoryEntity
     */
    public function insert(CategoryEntity $category)
    {
        $attributes = $category->getAttributes();
        $now = date('Y-m-d H:i:s');

        $attributes = array_merge($attributes, [
            'createdAt' => $now,
            'updatedAt' => $now,
        ]);

        $id = $this->conn->table($this->table)->insertGetId($attributes);

        return $this->createEntity(array_merge($attributes, compact('id')));
    }

    /**
     * Update category
     *
     * @param CategoryEntity $category category object
     * @return CategoryEntity
     */
    public function update(CategoryEntity $category)
    {
        $diff = $category->diff();

        $updatedAt = [];
        if (count($diff) > 0) {
            $updatedAt = ['updatedAt' => date('Y-m-d H:i:s')];
            $this->conn->table($this->table)
                ->where('id', $category->id)
                ->update(array_merge($diff, $updatedAt));
        }

        return $this->createEntity(array_merge($category->getOriginal(), $diff, $updatedAt));
    }

    /**
     * Delete category
     *
     * @param CategoryEntity $category category object
     * @return int affecting statement
     */
    public function delete(CategoryEntity $category)
    {
        return $this->conn->table($this->table)->where('id', $category->id)->delete();
    }

    /**
     * Increment has item count
     *
     * @param CategoryEntity $category category object
     * @param int            $amount   increase value
     * @return int affecting statement
     */
    public function increment(CategoryEntity $category, $amount = 1)
    {
        return $this->conn->table($this->table)->where('id', $category->id)->increment('count', $amount);
    }

    /**
     * Decrement has item count
     *
     * @param CategoryEntity $category category object
     * @param int            $amount   decrease value
     * @return int affecting statement
     */
    public function decrement(CategoryEntity $category, $amount = 1)
    {
        return $this->conn->table($this->table)->where('id', $category->id)->decrement('count', $amount);
    }

    /**
     * Create entity object from attributes
     *
     * @param array $attributes object attributes
     * @return CategoryEntity
     */
    protected function createEntity(array $attributes)
    {
        return new CategoryEntity($attributes);
    }
}
