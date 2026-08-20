<?php
/**
 * TagRepository.php
 *
 * PHP version 7
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tag;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Xpressengine\Support\EloquentRepositoryTrait;

/**
 * TagRepository.php
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TagRepository
{
    use EloquentRepositoryTrait;

    /**
     * Attach tag to taggable
     *
     * @param string $taggableId taggable id
     * @param Tag[]  $tags       tag instances
     * @return void
     */
    public function attach($taggableId, $tags)
    {
        $conn = $this->createModel()->getConnection();
        $position = 0;

        foreach ($tags as $tag) {
            if ($this->persistTaggable($conn, $tag, $taggableId, $position)) {
                $tag->increment('count');
            }

            $position++;
        }
    }

    /**
     * Detach tag to taggable
     *
     * @param string $taggableId taggable id
     * @param Tag[]  $tags       tag instances
     * @return void
     * @throws \Exception
     */
    public function detach($taggableId, $tags)
    {
        $conn = $this->createModel()->getConnection();
        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $conn->table($tag->getTaggableTable())
                ->where('tag_id', $tag->getKey())
                ->where('taggable_id', $taggableId)
                ->delete();

            $tag->decrement('count');

            if ($tag->count <= 0) {
                $tag->delete();
            }
        }
    }

    /**
     * Sync tags to taggable
     *
     * 대상 아이디에 연결된 태그를 주어진 태그 목록으로 갱신한다.
     * 이미 연결된 태그는 position 만 갱신하고, 목록에서 빠진 태그는 연결을 해제한다.
     *
     * @param  string  $taggableId  taggable id
     * @param  Tag[]  $tags  tag instances
     *
     * @return void
     *
     * @throws Exception
     */
    public function sync($taggableId, $tags)
    {
        $conn = $this->createModel()->getConnection();
        $position = 0;
        $tagIds = [];

        foreach ($tags as $tag) {
            if ($this->persistTaggable($conn, $tag, $taggableId, $position)) {
                $tag->increment('count');
            }

            $tagIds[] = $tag->getKey();
            $position++;
        }

        // 대상 아이디에 연결된 태그중 갱신된 목록에 없는 태그는 연결 해제 처리
        $removes = $this->fetchByTaggable($taggableId)->filter(
            function (Tag $tag) use ($tagIds) {
                return in_array($tag->getKey(), $tagIds) === false;
            }
        );

        $this->detach($taggableId, $removes);
    }

    /**
     * Update an existing tag relation before inserting a new one.
     *
     * @param  mixed  $conn  database connection
     * @param  Tag  $tag  tag instance
     * @param  string  $taggableId  taggable id
     * @param  int  $position  relation position
     *
     * @return bool
     */
    private function persistTaggable($conn, Tag $tag, $taggableId, $position)
    {
        $table = $tag->getTaggableTable();
        $relation = $conn->table($table)
            ->where('tag_id', $tag->getKey())
            ->where('taggable_id', $taggableId);

        if ($relation->exists()) {
            $relation->update(['position' => $position]);

            return false;
        }

        $inserted = $conn->table($table)->insertOrIgnore([
            'tag_id' => $tag->getKey(),
            'taggable_id' => $taggableId,
            'position' => $position,
            'created_at' => $this->getNow()
        ]);

        if ($inserted > 0) {
            return true;
        }

        $conn->table($table)
            ->where('tag_id', $tag->getKey())
            ->where('taggable_id', $taggableId)
            ->update(['position' => $position]);

        return false;
    }

    /**
     * Returns tags of the taggable
     *
     * @param string $taggableId taggable id
     * @return Collection|Tag[]
     */
    public function fetchByTaggable($taggableId)
    {
        $model = $this->createModel();

        return $this->query()
            ->rightJoin($model->getTaggableTable(), $model->getTable().'.id', '=', $model->getTaggableTable().'.tag_id')
            ->where('taggable_id', $taggableId)
            ->orderBy('position')
            ->select([$model->getTable().'.*'])
            ->get();
    }

    /**
     * Returns taggables of the tag
     *
     * @param string $tagId tagId
     * @return \Illuminate\Support\Collection
     */
    public function fetchByTag($tagId)
    {
        $model = $this->createModel();
        $conn = $model->getConnection();

        return $conn->table($model->getTaggableTable())
            ->where('tag_id', $tagId)
            ->get();
    }

    /**
     * Returns most popular tags
     *
     * @param string|null $instanceId instance id
     * @param int         $take       take count
     * @return Collection|Tag[]
     */
    public function fetchPopular($instanceId = null, $take = 15)
    {
        $query = $this->query()->orderBy('count', 'desc')->orderBy('id', 'desc')->take($take);

        if ($instanceId !== null) {
            $query->where('instance_id', $instanceId);
        }

        return $query->get();
    }

    /**
     * Returns most popular tags in whole
     *
     * @param int $take take count
     * @return Collection|Tag[]
     */
    public function fetPopularWhole($take = 15)
    {
        return $this->fetchPopular(null, $take);
    }

    /**
     * Returns most popular tags of date period
     *
     * @param \DateTime|string      $since      begin date
     * @param \DateTime|string|null $until      end date
     * @param string|null           $instanceId instance id
     * @param int                   $take       take count
     * @return Collection|Tag[]
     */
    public function fetchPopularPeriod($since, $until = null, $instanceId = null, $take = 15)
    {
        $model = $this->createModel();

        $query = $this->query()
            ->rightJoin($model->getTaggableTable(), $model->getTaggableTable().'.tag_id', '=', $model->getTable().'.id')
            ->select([$model->getTable().'.*', new Expression('count(*) as cnt')])
            ->groupBy($model->getTable().'.word')
            ->orderBy('cnt', 'desc')
            ->orderBy('id', 'desc')
            ->take($take);

        if ($until !== null) {
            $query->whereBetween($this->getTaggableTable().'.created_at', [$since, $until]);
        } else {
            $query->where($this->getTaggableTable().'.created_at', '>', $since);
        }

        if ($instanceId !== null) {
            $query->where($model->getTable().'.instance_id', $instanceId);
        }

        return $query->get();
    }

    /**
     * Returns most popular tags of date period in whole
     *
     * @param \DateTime|string      $since begin date
     * @param \DateTime|string|null $until end date
     * @param int                   $take  take count
     * @return Collection|Tag[]
     */
    public function fetchPopularPeriodWhole($since, $until = null, $take = 15)
    {
        return $this->fetchPopularPeriod($since, $until, null, $take);
    }

    /**
     * Search similar tags by given string
     *
     * @param string      $decomposed decomposed word
     * @param int         $take       take count
     * @param string|null $instanceId instance id of taggable
     * @return Collection|Tag[]
     */
    public function fetchSimilar($decomposed, $take = 15, $instanceId = null)
    {
        $query = $this->query()
            ->where('decomposed', 'like', $decomposed . '%')
            ->orderBy('count', 'desc')
            ->take($take);

        if ($instanceId) {
            $query->where('instance_id', $instanceId);
        }

        return $query->get();
    }

    /**
     * Returns Datetime instance for now
     *
     * @return \DateTime|Carbon
     */
    protected function getNow()
    {
        return Carbon::now();
    }
}
