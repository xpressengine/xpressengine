<?php
/**
 * This file is node model class.
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support\Tree;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Xpressengine\Database\Eloquent\DynamicModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Node
 *
 * @category    Category
 * @package     Xpressengine\Category
 *
 * @property Collection $ancestors
 * @property Collection $descendants
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class Node extends DynamicModel implements NodeInterface
{
    use TreeMakerTrait;

    /**
     * @var NodeInterface
     */
    protected $parent;
    /**
     * children collection of model
     *
     * @var Collection
     */
    protected $children;

    /**
     * Aggregator relationship
     *
     * @return BelongsTo
     */
    public function aggregator()
    {
        return $this->belongsTo($this->getAggregatorModel(), $this->getAggregatorKeyName());
    }

    /**
     * Ancestors relationship
     *
     * @param bool $without without self node when value is true
     * @return BelongsToMany
     */
    public function ancestors($without = true)
    {
        $relation = $this->belongsToMany(
            static::class,
            $this->getClosureTable(),
            $this->getDescendantName(),
            $this->getAncestorName()
        )->withPivot($this->getDepthName());

        if ($without) {
            $relation->wherePivot($this->getDepthName(), '!=', 0);
        }


        return $relation;
    }

    /**
     * Descendants relationship
     *
     * @param bool $without without self node when value is true
     * @return BelongsToMany
     */
    public function descendants($without = true)
    {
        $relation = $this->belongsToMany(
            static::class,
            $this->getClosureTable(),
            $this->getAncestorName(),
            $this->getDescendantName()
        )->withPivot($this->getDepthName());

        if ($without) {
            $relation->wherePivot($this->getDepthName(), '!=', 0);
        }

        return $relation;
    }

    /**
     * Get the unique identifier for the node
     *
     * @return string|int
     */
    public function getNodeIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the unique identifier name for the node
     *
     * @return string
     */
    public function getNodeIdentifierName()
    {
        return $this->getKeyName();
    }

    /**
     * Get the parent identifier for the node
     *
     * @return string|int
     */
    public function getParentNodeIdentifier()
    {
        return $this->{$this->getParentIdName()};
    }

    /**
     * Get a model's parent node
     *
     * @return Node|static
     */
    public function getParent()
    {
        if (!$this->parent && $this->ancestors->count() > 0) {
            $this->parent = $this->ancestors->first(function ($i, $model) {
                return $model->pivot->{$this->getDepthName()} == 1;
            });
        }

        return $this->parent;
    }

    /**
     * Set parent node
     *
     * @param NodeInterface $node parent node
     * @return void
     */
    public function setParent(NodeInterface $node)
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
        if (!$this->children) {
            $this->getDescendantTree(true);
        }

        return $this->children;
    }

    /**
     * Set child nodes
     *
     * @param NodeInterface[] $children children node interfaces
     * @return void
     */
    public function setChildren($children = [])
    {
        $this->children = Collection::make($children);
    }

    /**
     * Add child node
     *
     * @param NodeInterface $node child node
     * @return void
     */
    public function addChild(NodeInterface $node)
    {
        $this->children()->put($node->getNodeIdentifier(), $node);
    }

    /**
     * Check having child and return the boolean result.
     *
     * @return bool
     */
    public function hasChild()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Returns children collection
     *
     * @return Collection
     */
    protected function children()
    {
        if (!$this->children) {
            $this->children = new Collection();
        }

        return $this->children;
    }

    /**
     * Get a descendant tree collection of model
     *
     * @param bool $withSelf flag for descendant tree with self
     * @return Tree
     */
    public function getDescendantTree($withSelf = false)
    {
        $nodes = $this->descendants->all();
        if ($withSelf) {
            $nodes = array_merge($nodes, [$this]);
        }

        return $this->makeTree($nodes);
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
     * Get node model for breadcrumbs
     *
     * @return Collection
     */
    public function getBreadcrumbs()
    {
        if ($this->parent) {
            return $this->parent->getBreadcrumbs()->push($this);
        }

        return $this->ancestors->sort(function ($a, $b) {
            $aDepth = $a->pivot->{$this->getDepthName()};
            $bDepth = $b->pivot->{$this->getDepthName()};

            if ($aDepth == $bDepth) {
                return 0;
            }

            return $aDepth > $bDepth ? -1 : 1;
        })->push($this);
    }

    /**
     * Scope for get node items of root
     *
     * @param Builder $query query builder
     * @return Builder
     */
    public function scopeRoots(Builder $query)
    {
        return $query->whereNull($this->getParentIdName())->orderBy($this->getOrderKeyName(), 'asc');
    }

    /**
     * Scope for get node items of progenitor
     *
     * @param Builder    $query      query builder
     * @param Aggregator $aggregator category instance
     * @return Builder
     */
    public function scopeProgenitors(Builder $query, $aggregator)
    {
        return $this->scopeRoots($query)->where($this->getAggregatorKeyName(), $aggregator->getKey());
    }

    /**
     * Get the pivot table for model's hierarchy
     *
     * @return string
     */
    abstract public function getClosureTable();

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
     * Get the aggregator model name for model
     *
     * @return string
     */
    abstract public function getAggregatorModel();

    /**
     * Get the aggregator key name for model
     *
     * @return string
     */
    abstract public function getAggregatorKeyName();
}
