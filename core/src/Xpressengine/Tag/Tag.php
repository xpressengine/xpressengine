<?php
/**
 * This file is tag model class
 *
 * PHP version 5
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Tag;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * Class Tag
 *
 * @category    Tag
 * @package     Xpressengine\Tag
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Tag extends DynamicModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * The table associated with the model for morph.
     *
     * @var string
     */
    protected $taggableTable = 'taggables';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'count'];

    /**
     * Used count of model
     *
     * @return int
     */
    public function getCount()
    {
        if (array_key_exists('cnt', $this->getAttributes())) {
            return $this->getAttribute('cnt');
        } else {
            return $this->getAttribute('count');
        }
    }

    /**
     * Returns tags of the taggable
     *
     * @param string $taggableId taggable id
     * @return Collection|static[]
     *
     * @deprecated since beta.17. use TagRepository::fetchByTaggable (XeTag::fetchByTaggable) instead.
     */
    public static function getByTaggable($taggableId)
    {
        $model = new static;

        return $model->newQuery()
            ->rightJoin($model->getTaggableTable(), $model->getTable().'.id', '=', $model->getTaggableTable().'.tagId')
            ->where('taggableId', $taggableId)
            ->orderBy('position')
            ->select([$model->getTable().'.*'])
            ->get();
    }

    /**
     * Returns most popular tags
     *
     * @param string|null $instanceId instance id
     * @param int         $take       take count
     * @return Collection|static[]
     *
     * @deprecated since beta.17. use TagRepository::fetchPopular (XeTag::fetchPopular) instead.
     */
    public static function getPopular($instanceId = null, $take = 15)
    {
        $model = new static;

        $query = $model->newQuery()->orderBy('count', 'desc')->orderBy('id', 'desc')->take($take);

        if ($instanceId !== null) {
            $query->where('instanceId', $instanceId);
        }

        return $query->get();
    }


    /**
     * Returns most popular tags in whole
     *
     * @param int $take take count
     * @return Collection|static[]
     *
     * @deprecated since beta.17. use TagRepository::fetchPopularWhole (XeTag::fetchPopularWhole) instead.
     */
    public static function getPopularWhole($take = 15)
    {
        return static::getPopular(null, $take);
    }

    /**
     * Returns most popular tags of date period
     *
     * @param \DateTime|string      $since      begin date
     * @param \DateTime|string|null $until      end date
     * @param string|null           $instanceId instance id
     * @param int                   $take       take count
     * @return Collection|static[]
     *
     * @deprecated since beta.17. use TagRepository::fetchPopularPeriod (XeTag::fetchPopularPeriod) instead.
     */
    public static function getPopularPeriod($since, $until = null, $instanceId = null, $take = 15)
    {
        $model = new static;

        $query = $model->newQuery()
            ->rightJoin($model->getTaggableTable(), $model->getTaggableTable().'.tagId', '=', $model->getTable().'.id')
            ->select([$model->getTable().'.*', new Expression('count(*) as cnt')])
            ->groupBy($model->getTable().'.word')
            ->orderBy('cnt', 'desc')
            ->orderBy('id', 'desc')
            ->take($take);

        $model->wherePeriod($query, $since, $until);

        if ($instanceId !== null) {
            $query->where($model->getTable().'.instanceId', $instanceId);
        }

        return $query->get();
    }

    /**
     * Period query helper
     *
     * @param Builder               $query query builder
     * @param \DateTime|string      $since begin date
     * @param \DateTime|string|null $until end date
     * @return void
     *
     * @deprecated since beta.17.
     */
    private function wherePeriod(Builder $query, $since, $until = null)
    {
        if ($until !== null) {
            $query->whereBetween($this->getTaggableTable().'.createdAt', [$since, $until]);
        } else {
            $query->where($this->getTaggableTable().'.createdAt', '>', $since);
        }
    }

    /**
     * Returns most popular tags of date period in whole
     *
     * @param \DateTime|string      $since begin date
     * @param \DateTime|string|null $until end date
     * @param int                   $take  take count
     * @return Collection|static[]
     *
     * @deprecated since beta.17. use TagRepository::fetchPopularPeriodWhole (XeTag::fetchPopularPeriodWhole) instead.
     */
    public static function getPopularPeriodWhole($since, $until = null, $take = 15)
    {
        return static::getPopularPeriod($since, $until, null, $take);
    }

    /**
     * Returns table
     *
     * @return string
     */
    public function getTaggableTable()
    {
        return $this->taggableTable;
    }
}
