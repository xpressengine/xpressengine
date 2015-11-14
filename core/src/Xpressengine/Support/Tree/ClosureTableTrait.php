<?php
/**
 * ClosureTable Trait
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Support\Tree;

use Xpressengine\Database\VirtualConnectionInterface;

/**
 * Tree 구조의 기본이 되는 ClosureTable 의 구현에 대한 기능을 제공
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
trait ClosureTableTrait
{
    /**
     * database connection
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * @param VirtualConnectionInterface $conn database conn
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * just insert self node Hierarchy
     *
     * @param NodeInterface $node node interface
     *
     * @return bool
     */
    public function rawInsertHierarchy(NodeInterface $node)
    {
        return $this->conn->table($this->hierarchyTable)->insert(
            ['ancestor' => $node->id, 'descendant' => $node->id]
        );
    }

    /**
     * insert Hierarchy
     *
     * @param NodeInterface $descendant child node instance
     * @param NodeInterface $ancestor   parent node instance
     *
     * @return bool
     */
    public function insertHierarchy(NodeInterface $descendant, NodeInterface $ancestor = null)
    {
        $result = $this->rawInsertHierarchy($descendant);

        if ($ancestor !== null) {
            $result = $this->linkHierarchy($descendant, $ancestor);
        }

        return $result;
    }

    /**
     * linked parent and child relation
     *
     * @param NodeInterface $descendant child node instance
     * @param NodeInterface $ancestor   parent node instance
     * @return bool
     */
    public function linkHierarchy(NodeInterface $descendant, NodeInterface $ancestor)
    {
        $prefix = $this->conn->getTablePrefix();
        $expression = $this->conn->raw(
            implode(' ', [
                "insert into {$prefix}{$this->hierarchyTable} (`ancestor`, `descendant`, `depth`) ",
                "select a.`ancestor`, d.`descendant`, a.`depth` + d.`depth` + 1 ",
                "from {$prefix}{$this->hierarchyTable} a, {$prefix}{$this->hierarchyTable} d ",
                "where a.`descendant` = '{$ancestor->id}' and d.`ancestor` = '{$descendant->id}'"
            ])
        );
        return $this->conn->statement($expression);
    }

    /**
     * unlinked parent and child relation
     *
     * @param NodeInterface $descendant child node instance
     * @param NodeInterface $ancestor   parent node instance
     * @return int affected row count
     */
    public function unlinkHierarchy(NodeInterface $descendant, NodeInterface $ancestor)
    {
        $subQuery = $this->conn->table($this->hierarchyTable . ' as a')
            ->join($this->hierarchyTable . ' as rel', 'a.ancestor', '=', 'rel.ancestor')
            ->join($this->hierarchyTable . ' as d', 'd.descendant', '=', 'rel.descendant')
            ->where('a.descendant', $ancestor->id)
            ->where('d.ancestor', $descendant->id)
            ->select(['rel.id'])->toSql();

        $query = $this->conn->table($this->hierarchyTable);

        $query->whereRaw('`id` in (select `id` from (' . $subQuery . ') as `temp`)', [$ancestor->id, $descendant->id]);

        return $query->delete();
    }

    /**
     * remove Hierarchy
     * remove related hierarchy about single node
     *
     * @param NodeInterface $node node instance
     *
     * @return int affected row count
     */
    public function removeHierarchy(NodeInterface $node)
    {
        return $this->conn->table($this->hierarchyTable)
            ->where('ancestor', $node->id)
            ->orwhere('descendant', $node->id)
            ->delete();
    }

    /**
     * remove hierarchy record
     *
     * @param NodeInterface $node term instance
     *
     * @return int affected row count
     */
    public function removeHierarchyToMakeLostParents(NodeInterface $node)
    {
        $subQuery = $this->conn->table($this->hierarchyTable . ' as a')
            ->join($this->hierarchyTable . ' as rel', 'a.ancestor', '=', 'rel.ancestor')
            ->join($this->hierarchyTable . ' as d', 'd.descendant', '=', 'rel.descendant')
            ->join($this->hierarchyTable . ' as del', 'a.descendant', '=', 'del.ancestor')
            ->whereRaw('`d`.`ancestor` = `del`.`descendant`');
        $subQuery->where(function ($query) use ($node) {
            $query->where('del.ancestor', $node->id)
                ->orWhere('del.descendant', $node->id);
        });
        $subQuery->where('del.depth', '<', 2)->select(['rel.id']);

        return $this->conn->table($this->hierarchyTable)
            ->whereRaw('`id` in (select `id` from (' . $subQuery->toSql() . ') as `temp`)', [$node->id, $node->id, 2])
            ->delete();
    }

    /**
     * returns ancestor list
     *
     * @param NodeInterface $node        descendant node instance
     * @param int           $depth       want depth
     * @param bool          $excludeSelf self instance exclude flag
     *
     * @return nodeInterface[] instance
     */
    public function fetchAsc(NodeInterface $node, $depth = 0, $excludeSelf = true)
    {
        $rows = $this->conn->table($this->nodeTable)
            ->whereIn('id', function ($query) use ($node, $depth, $excludeSelf) {
                $query->select('ancestor')
                    ->from($this->hierarchyTable)
                    ->where('descendant', $node->id);

                if ($depth > 0) {
                    $query->where('depth', '<=', $depth);
                }

                if ($excludeSelf === true) {
                    $query->where('depth', '!=', 0);
                }
            })->get();

        $nodes = [];
        foreach ($rows as $row) {
            $nodes[] = $this->createNodeModel((array)$row);
        }

        return $nodes;
    }

    /**
     * returns descendant list
     *
     * @param NodeInterface $node        ancestor term instance
     * @param int           $depth       want depth
     * @param bool          $excludeSelf self instance exclude flag
     *
     * @return nodeInterface[] instance
     */
    public function fetchDesc(NodeInterface $node, $depth = 0, $excludeSelf = true)
    {
        $rows = $this->conn->table($this->nodeTable)
            ->whereIn('id', function ($query) use ($node, $depth, $excludeSelf) {
                $query->select('descendant')
                    ->from($this->hierarchyTable)
                    ->where('ancestor', $node->id);

                if ($depth > 0) {
                    $query->where('depth', '<=', $depth);
                }

                if ($excludeSelf === true) {
                    $query->where('descendant', '!=', $node->id);
                }
            })->get();

        $nodes = [];
        foreach ($rows as $row) {
            $nodes[] = $this->createNodeModel((array)$row);
        }

        return $nodes;
    }

    /**
     * fetch node list tree type
     *
     * @param NodeInterface $top   node instance
     * @param int           $depth want get depth
     *
     * @return TreeCollection
     */
    public function fetchTree(NodeInterface $top, $depth = 0)
    {
        $prefix = $this->conn->getTablePrefix();
        $query = $this->conn->table($this->nodeTable . " as t")
            ->selectRaw(
                "{$prefix}t.*, {$prefix}h.`depth`, GROUP_CONCAT({$prefix}crumbs.`ancestor` " .
                "order by {$prefix}crumbs.`depth` desc) AS breadcrumbs"
            )
            ->join($this->hierarchyTable . ' as h', 't.id', '=', 'h.descendant')
            ->join($this->hierarchyTable . ' as crumbs', 'crumbs.descendant', '=', 'h.descendant')
            ->where('h.ancestor', $top->id);

        if ($depth > 0) {
            $query->where('h.depth', '<', $depth);
        }

        $rows = $query->groupBy('t.id')->orderBy('breadcrumbs')->orderBy('t.ordering')->get();

        $nodes = [];
        foreach ($rows as $row) {
            $row = (array)$row;

            $node = $this->createNodeModel(array_diff_key($row, array_flip(['depth', 'breadcrumbs'])));
            $node->setdepth($row['depth']);
            $node->setTreeNodePath($row['breadcrumbs']);

            $nodes[$node->id] = $node;
        }
        return new TreeCollection($nodes);
    }
}
