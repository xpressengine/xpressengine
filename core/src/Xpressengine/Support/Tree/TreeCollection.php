<?php
/**
 * TreeCollection Class
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

use ArrayAccess;
use JsonSerializable;

/**
 * Tree Collection NodeInterface 들을 담고 Tree 를 구성하고 있는 Collection
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class TreeCollection implements ArrayAccess, JsonSerializable
{
    /**
     * @var $rawNodes NodeInterface[]
     */
    protected $rawNodes;
    /**
     * @var $treeNodes NodeInterface[]
     */
    protected $treeNodes;

    /**
     * @param NodeInterface[] $rawNodes nodes
     */
    public function __construct($rawNodes)
    {
        $this->rawNodes = $rawNodes;
        $this->arrange();
    }

    /**
     * getRawNodes
     *
     * @return NodeInterface[]
     */
    public function getNodes()
    {
        return $this->rawNodes;
    }

    /**
     * getTree
     *
     * @return array
     */
    public function getTree()
    {
        return $this->treeNodes;
    }

    /**
     * Adds a node to this node
     *
     * @param NodeInterface $node nodes
     *
     * @return NodeInterface
     */
    public function add(NodeInterface $node)
    {
        /**
         * @var array $nodes
         */
        $this->rawNodes[$node->id] = $node;
        $this->arrange();
        return $this->rawNodes[$node->id];

    }

    /**
     * Arrange From Raw nodes to Menu Tree nodes
     *
     * @return void
     */
    protected function arrange()
    {
        $root = [];
        $nodes = $this->rawNodes;

        foreach ($nodes as $node) {
            if (isset($nodes[$node->parentId])) {
                $nodes[$node->parentId]->addChild($node);
                $node->setParent($nodes[$node->parentId]);
            } else {
                $root[$node->id] = $node;
            }
        }
        $this->treeNodes = $this->sort($root);
    }

    /**
     * sort node tree
     *
     * @param NodeInterface[] $tree nodes
     *
     * @return array
     */
    protected function sort(array $tree)
    {
        foreach ($tree as $id => $item) {
            if ($item->hasChild()) {
                $tree[$id]->setChildren($this->sort($item->getChildren()));
            }
        }

        uasort($tree, function ($a, $b) {
            if ($a->ordering == $b->ordering) {
                return 0;
            }

            return $a->ordering < $b->ordering ? -1 : 1;
        });

        return $tree;
    }

    /**
     * size of Tree Collection nodes
     *
     * @return int
     */
    public function size()
    {
        return count($this->rawNodes);
    }

    /**
     * Implementation of ArrayAccess offsetExists()
     * Whether a offset exists
     *
     * @param mixed $offset array access offset
     *
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return isset($this->rawNodes[$offset]);
    }

    /**
     * Implementation of ArrayAccess offsetGet()
     * Offset to retrieve
     *
     * @param mixed $offset array access offset
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        if (isset($this->rawNodes[$offset])) {
            return $this->rawNodes[$offset];
        } else {
            return null;
        }
    }

    /**
     * Implementation of ArrayAccess offsetSet()
     * Offset to set
     *
     * @param mixed $offset array access offset
     * @param mixed $value  array access value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->rawNodes[$offset] = $value;
    }

    /**
     * Implementation of ArrayAccess offsetUnset()
     * Offset to unset
     *
     * @param mixed $offset array access offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->rawNodes[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *       which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return $this->getTree();
    }
}
