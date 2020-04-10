<?php
/**
 * NodePositionTrait
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support\Tree;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Arr;

/**
 * Trait NodePositionTrait
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait NodePositionTrait
{
    /**
     * Linked parent and child relation
     *
     * @param Node $item   child item instance
     * @param Node $parent parent item instance
     * @return bool
     */
    protected function linkHierarchy(Node $item, Node $parent)
    {
        $conn = $item->getConnection();
        $prefix = $conn->getTablePrefix();
        $table = $item->getClosureTable();
        $ancestor = $item->getAncestorName();
        $descendant = $item->getDescendantName();
        $depth = $item->getDepthName();

        $select = $conn->table($table . ' as a')
            ->joinWhere($table . ' as d', "d.{$ancestor}", '=', $item->getKey())
            ->where("a.{$descendant}", '=', $parent->getKey())
            ->select([
                "a.{$ancestor}",
                "d.{$descendant}",
                new Expression("`{$prefix}a`.`{$depth}` + `{$prefix}d`.`{$depth}` + 1")
            ]);

        $bindings = $select->getBindings();

        $insertQuery = sprintf("insert into %s (`{$ancestor}`, `{$descendant}`, `{$depth}`) ", $prefix . $table)
            . $select->toSql();

        return $conn->insert($insertQuery, $bindings);
    }

    /**
     * unlinked parent and child relation
     *
     * @param Node $item   child item instance
     * @param Node $parent parent item instance
     * @return int affected row count
     */
    protected function unlinkHierarchy(Node $item, Node $parent)
    {
        $conn = $item->getConnection();
        $table = $item->getClosureTable();
        $ancestor = $item->getAncestorName();
        $descendant = $item->getDescendantName();

        $rows = $conn->table($table . ' as a')
            ->join($table . ' as rel', "a.{$ancestor}", '=', "rel.{$ancestor}")
            ->join($table . ' as d', "d.{$descendant}", '=', "rel.{$descendant}")
            ->where("a.{$descendant}", $parent->getKey())
            ->where("d.{$ancestor}", $item->getKey())
            ->get(['rel.' . $item->getKeyName()]);

        $ids = Arr::pluck($rows, $item->getKeyName());

        return $conn->table($table)->whereIn($item->getKeyName(), $ids)->delete();
    }

    /**
     * Set item ordering value
     *
     * @param Node     $item     item object
     * @param int|null $position sequence value
     * @return void
     */
    public function setOrder(Node $item, $position = null)
    {
        /** @var Node $parent */
        if (!$parent = $item->getParent()) {
            $children = $item->aggregator->getProgenitors();
        } else {
            $children = $parent->getChildren();
        }

        $position = $position !== null ? $position : count($children);

        /** @var Collection $children */
        $children = $children->filter(function (Node $model) use ($item) {
            return $model->getKey() != $item->getKey();
        });

        $children = $children->slice(0, $position)
            ->merge([$item])
            ->merge($children->slice($position));

        $children->each(function (Node $model, $idx) {
            $model->{$model->getOrderKeyName()} = $idx;
            $model->save();
        });
    }
}
