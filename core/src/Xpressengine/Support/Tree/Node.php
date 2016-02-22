<?php
/**
 * This file is node model class.
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
namespace Xpressengine\Category\Models;

use Illuminate\Database\Eloquent\Collection;
use Xpressengine\Database\Eloquent\DynamicModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Node
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 *
 * @property Collection $ancestors
 * @property Collection $descendants
 */
abstract class Node extends DynamicModel
{
    protected $parent;
    /**
     * children collection of model
     *
     * @var Collection
     */
    protected $children;

    /**
     * Ancestors relationship
     *
     * @return BelongsToMany
     */
    public function ancestors()
    {
        $relation = $this->belongsToMany(
            static::class,
            $this->getHierarchyTable(),
            $this->getDescendantName(),
            $this->getAncestorName()
        )->withPivot($this->getDepthName());

        $relation->wherePivot($this->getDepthName(), '!=', 0);

        return $relation;
    }

    /**
     * Descendants relationship
     *
     * @return BelongsToMany
     */
    public function descendants()
    {
        $relation = $this->belongsToMany(
            static::class,
            $this->getHierarchyTable(),
            $this->getAncestorName(),
            $this->getDescendantName()
        )->withPivot($this->getDepthName());

        $relation->wherePivot($this->getDepthName(), '!=', 0);

        return $relation;
    }

    /**
     * Get a model's parent node
     *
     * @return Node|static
     */
    public function getParent()
    {
        if (!$this->parent) {
            $this->parent = $this->ancestors->first(function ($i, $model) {
                return $model->pivot->{$this->getDepthName()} == 1;
            });
        }

        return $this->parent;
    }

    public function setParent(Node $node)
    {
        $this->parent = $node;
    }

    /**
     * Get a children collection of model
     *
     * @return Collection
     */
    public function getChildren()
    {
        if (array_key_exists($this->getTreeRelationName(), $this->getRelations())) {
            return $this->getRelation($this->getTreeRelationName());
        }

        if (!$this->children) {
            $this->children = $this->where($this->getParentIdName(), $this->id)->get()->sort([$this, 'orderSort']);
        }

        return $this->children;
    }

    /**
     * Sort siblings
     *
     * @param Node $a item instance
     * @param Node $b item instance
     * @return int
     */
    public function orderSort(Node $a, Node $b)
    {
        $aOrdering = $a->{$this->getOrderKeyName()};
        $bOrdering = $b->{$this->getOrderKeyName()};

        if ($aOrdering == $bOrdering) {
            return 0;
        }

        return $aOrdering < $bOrdering ? -1 : 1;
    }

    /**
     * Get a descendant tree collection of model
     *
     * @param bool $withSelf flag for descendant tree with self
     * @return Collection
     */
    public function getDescendantTree($withSelf = false)
    {
        $bag = [];
        $collection = new Collection();

        if ($withSelf && $this->relationLoaded($this->getTreeRelationName())) {
            return $collection->put($this->getKey(), $this);
        }

        $items = $this->descendants->sort([$this, 'orderSort']);

        /** @var Node $item */
        foreach ($items as $item) {
            $bag[$item->getKey()] = $item;
        }

        foreach ($items as $item) {
            $parentId = $item->{$this->getParentIdName()};
            if (array_key_exists($parentId, $bag)) {
                $bag[$parentId]->addRelation($item->getTreeRelationName(), $item);
            } else {
                $collection->put($item->getKey(), $item);
            }
        }

        if ($withSelf) {
            $this->setRelation($this->getTreeRelationName(), $collection);

            return new Collection([$this->getKey() => $this]);
        }

        return $collection;
    }

    /**
     * Add a node item on the model
     *
     * @param string $relation relation name
     * @param Node   $item     item instance
     * @return void
     */
    public function addRelation($relation, Node $item)
    {
        if (!$this->relationLoaded($relation)) {
            $this->setRelation($relation, new Collection([$item->getKey() => $item]));
        } else {
            $this->getRelation($relation)->put($item->getKey(), $item);
        }
    }

    /**
     * Returns a number of descendants
     *
     * @return int
     */
    public function getDescendantCount()
    {
        if ($this->relationLoaded('descendants')) {
            return count($this->descendants);
        }

        return $this->descendants()->newPivotStatement()
            ->where($this->getAncestorName(), $this->getKey())
            ->where($this->getDepthName(), '>', 0)
            ->count();
    }

    /**
     * Get the depth value of model
     *
     * @return int
     */
    public function getDepth()
    {
        return count($this->getBreadcrumbs()) - 1;
    }

    /**
     * Get primary key array for breadcrumbs
     *
     * @return array
     */
    public function getBreadcrumbs()
    {
        return $this->ancestors->sort(function ($a, $b) {
            $aDepth = $a->pivot->{$this->getDepthName()};
            $bDepth = $b->pivot->{$this->getDepthName()};

            if ($aDepth == $bDepth) {
                return 0;
            }

            return $aDepth > $bDepth ? -1 : 1;
        })->push($this)->pluck($this->getKeyName())->toArray();
    }

    /**
     * Scope for get node items of root
     *
     * @param Builder $query     query builder
     * @return Builder
     */
    public function scopeRoots(Builder $query)
    {
        return $query->whereNull($this->getParentIdName())->orderBy($this->getOrderKeyName(), 'asc');
    }

    /**
     * Get the pivot table for model's hierarchy
     *
     * @return string
     */
    abstract public function getHierarchyTable();

    /**
     * Get the ancestor key name of pivot table
     *
     * @return string
     */
    abstract public function getAncestorName();

    /**
     * Get the descendant key name of pivot table
     *
     * @return string
     */
    abstract public function getDescendantName();

    /**
     * Get the depth key name of pivot table
     *
     * @return string
     */
    abstract public function getDepthName();

    /**
     * Get the parent key name for model
     *
     * @return string
     */
    abstract public function getParentIdName();

    /**
     * Get the order key name for model
     *
     * @return string
     */
    abstract public function getOrderKeyName();

    /**
     * Get the relation name for tree relation
     *
     * @return string
     */
    public function getTreeRelationName()
    {
        return 'leaves';
    }
}
