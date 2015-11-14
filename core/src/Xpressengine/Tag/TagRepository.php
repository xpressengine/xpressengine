<?php
/**
 * This file is tag repository class
 *
 * PHP version 5
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Tag;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Database\DynamicQuery;

/**
 * 데이터베이스에 태그 정보 입출력 처리
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class TagRepository
{
    /**
     * Connection instance
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * Tag item table
     *
     * @var string
     */
    protected $itemTable = 'tag_item';

    /**
     * Tag used table
     *
     * @var string
     */
    protected $usedTable = 'tag_item_used';

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
     * Tag find by instanceId and word string
     *
     * @param string $instanceId instance id
     * @param string $word       tag word
     * @return TagEntity
     */
    public function findByInstanceIdAndWord($instanceId, $word)
    {
        $row = $this->conn->table($this->itemTable)->where('instanceId', $instanceId)->where('word', $word)->first();

        if ($row !== null) {
            return $this->createItem((array)$row);
        }

        return null;
    }

    /**
     * Get target has tags
     *
     * @param string $targetId target id
     * @return TagEntity[]
     */
    public function hasMany($targetId)
    {
        $rows = $this->conn->table($this->usedTable . ' as used')
            ->leftJoin($this->itemTable . ' as item', 'used.itemId', '=', 'item.id')
            ->where('used.targetId', $targetId)
            ->select(['item.*'])
            ->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createItem((array)$row);
        }

        return $items;
    }

    /**
     * Insert tag information
     *
     * @param TagEntity $tag tag object
     * @return TagEntity
     */
    public function insert(TagEntity $tag)
    {
        $attributes = array_merge($tag->getAttributes(), ['createdAt' => date('Y-m-d H:i:s')]);
        $id = $this->conn->table($this->itemTable)->insertGetId($attributes);

        return $this->createItem(array_merge($attributes, ['id' => $id]));
    }

    /**
     * Increase tag used count
     *
     * @param TagEntity $tag    tag object
     * @param int       $amount amount value
     * @return void
     */
    public function increment(TagEntity $tag, $amount = 1)
    {
        $this->conn->table($this->itemTable)->where('id', $tag->id)->increment('count', $amount);
    }

    /**
     * Decrease tag used count
     *
     * @param TagEntity $tag    tag object
     * @param int       $amount amount value
     * @return void
     */
    public function decrement(TagEntity $tag, $amount = 1)
    {
        $this->conn->table($this->itemTable)->where('id', $tag->id)->decrement('count', $amount);
    }

    /**
     * Check exists tag used information
     *
     * @param string    $targetId target id
     * @param TagEntity $tag      tag object
     * @return bool
     */
    public function existsUsed($targetId, TagEntity $tag)
    {
        return $this->conn->table($this->usedTable)->where('targetId', $targetId)->where('itemId', $tag->id)->exists();
    }

    /**
     * Insert a used log information
     *
     * @param string    $targetId target id
     * @param TagEntity $tag      tag object
     * @return void
     */
    public function insertUsed($targetId, TagEntity $tag)
    {
        $this->conn->table($this->usedTable)->insert([
            'targetId' => $targetId,
            'itemId' => $tag->id,
            'createdAt' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Delete a used log information
     *
     * @param string    $targetId target id
     * @param TagEntity $tag      tag object
     * @return void
     */
    public function deleteUsed($targetId, TagEntity $tag)
    {
        $this->conn->table($this->usedTable)->where('targetId', $targetId)->where('itemId', $tag->id)->delete();
    }

    /**
     * Get tags similar to the given string
     *
     * @param string $string     decomposed word string
     * @param string $instanceId instance id
     * @param int    $take       take item count
     * @return TagEntity[]
     */
    public function fetchSimilar($string, $instanceId, $take)
    {
        $query = $this->conn->table($this->itemTable);

        if ($instanceId !== null) {
            $query->where('instanceId', $instanceId);
        }

        $rows = $query->where('decomposed', 'like', $string . '%')->orderBy('count', 'desc')->take($take)->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createItem((array)$row);
        }

        return $items;
    }

    /**
     * Popular tags
     *
     * @param string|null $instanceId instance id
     * @param string      $since      since datetime
     * @param string      $until      until datetime
     * @param int         $take       take item count
     * @return TagEntity[]
     */
    public function popular($instanceId, $since, $until, $take)
    {
        $query = $this->conn->table($this->usedTable . ' as used')
            ->leftJoin($this->itemTable . ' as item', 'used.itemId', '=', 'item.id')
            ->selectRaw('item.*, count(*) as cnt');

        $this->periodWhere($query, $since, $until);

        if ($instanceId !== null) {
            $query->where('item.instanceId', $instanceId);
        }

        $rows = $query->groupBy('item.word')->orderBy('cnt', 'desc')->take($take)->get();

        $items = [];
        foreach ($rows as $row) {
            $row = (array)$row;
            $row['count'] = $row['cnt'];
            unset($row['cnt']);
            $items[] = $this->createItem($row);
        }

        return $items;
    }

    /**
     * For period search
     *
     * @param DynamicQuery $query xe database query builder
     * @param string       $since since datetime
     * @param string       $until until datetime
     * @return void
     */
    private function periodWhere(DynamicQuery &$query, $since, $until)
    {
        if ($since !== null && $until !== null) {
            $query->whereBetween('used.createdAt', [$since, $until]);
        } elseif ($since !== null) {
            $query->where('used.createdAt', '>', $since);
        } elseif ($until !== null) {
            $query->where('used.createdAt', '<', $until);
        }
    }

    /**
     * Count of used tag
     *
     * @param string $instanceId instance id
     * @param string $word       search specific word
     * @param string $since      since datetime
     * @param string $until      until datetime
     * @return int
     */
    public function count($instanceId, $word, $since, $until)
    {
        $query = $this->conn->table($this->usedTable . ' as used')
            ->leftJoin($this->itemTable . ' as item', 'used.itemId', '=', 'item.id');

        $this->periodWhere($query, $since, $until);

        if ($instanceId !== null) {
            $query->where('item.instanceId', $instanceId);
        }
        if ($word !== null) {
            $query->where('item.word', $word);
        }

        return $query->count();
    }

    /**
     * Specific word used target information
     *
     * return sample
     *   ['freeboard' => ['xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx']]
     *
     * @param string $word       specific word
     * @param string $instanceId instance id
     * @return array
     */
    public function getUsed($word, $instanceId)
    {
        $query = $this->conn->table($this->usedTable . ' as used')
            ->leftJoin($this->itemTable . ' as item', 'used.itemId', '=', 'item.id')
            ->select(['item.instanceId', 'used.targetId'])
            ->where('item.word', $word);

        if ($instanceId !== null) {
            $query->where('item.instanceId', $instanceId);
        }

        $rows = $query->get();

        $data = [];
        foreach ($rows as $row) {
            $row = (array)$row;
            if (isset($data[$row['instanceId']]) !== true) {
                $data[$row['instanceId']] = [];
            }

            $data[$row['instanceId']][] = $row['targetId'];
        }

        return empty($data) ? $data : ($instanceId === null ? $data : array_pop($data));
    }

    /**
     * Create a tag item
     *
     * @param array $attributes item attributes
     * @return TagEntity
     */
    protected function createItem(array $attributes)
    {
        return new TagEntity($attributes);
    }
}
