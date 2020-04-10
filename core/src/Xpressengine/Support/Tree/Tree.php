<?php
/**
 * This file is tree structure class.
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

use ArrayAccess;
use JsonSerializable;
use Illuminate\Support\Collection;

/**
 * Class Tree
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Tree implements ArrayAccess, JsonSerializable
{
    /**
     * @var Collection $rawNodes NodeInterface[]
     */
    protected $rawNodes;
    /**
     * @var Collection $treeNodes NodeInterface[]
     */
    protected $treeNodes;

    /**
     * @param NodeInterface[] $rawNodes nodes
     */
    public function __construct($rawNodes = [])
    {
        $nodes = Collection::make($rawNodes);
        if ($nodes->count() > 0) {
            $node = $nodes->first();
            $this->rawNodes = $nodes->keyBy($node->getNodeIdentifierName());
        } else {
            $this->rawNodes = $nodes;
        }

        $this->arrange();
    }

    /**
     * Make Tree instance
     *
     * @param NodeInterface[] $rawNodes nodes
     * @return static
     */
    public static function make($rawNodes = [])
    {
        return new static($rawNodes);
    }

    /**
     * getRawNodes
     *
     * @return Collection NodeInterface[]
     */
    public function getNodes()
    {
        return $this->rawNodes;
    }

    /**
     * getTree
     *
     * @return Collection
     */
    public function getTreeNodes()
    {
        return $this->treeNodes;
    }

    /**
     * Adds a node to this node
     *
     * @param NodeInterface $node nodes
     *
     * @return $this
     */
    public function add(NodeInterface $node)
    {
        $this->rawNodes[$node->getNodeIdentifier()] = $node;
        $parentId = $node->getParentNodeIdentifier();
        if ($parentId) {
            $parent = $this->rawNodes[$parentId];
            $parent->addChild($node);
            $parent->setChildren($this->sort($parent->getChildren()));
            $node->setParent($this->rawNodes[$parentId]);
        } else {
            $this->treeNodes[$node->getNodeIdentifier()] = $node;
        }

        return $this;
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

        /** @var NodeInterface $node */
        foreach ($nodes as $node) {
            $parentId = $node->getParentNodeIdentifier();
            if (isset($nodes[$parentId])) {
                $nodes[$parentId]->addChild($node);
                $node->setParent($nodes[$parentId]);
            } else {
                $root[$node->getNodeIdentifier()] = $node;
            }
        }
        $this->treeNodes = $this->fullSort($root);
    }

    /**
     * sort all nodes
     *
     * @param array $items nodes
     * @return array
     */
    protected function fullSort($items = [])
    {
        /** @var NodeInterface $item */
        foreach ($items as $item) {
            if ($item->hasChild()) {
                $item->setChildren($this->fullSort($item->getChildren()));
            }
        }

        return $this->sort($items);
    }

    /**
     * sort node tree
     *
     * @param NodeInterface[] $items nodes
     *
     * @return array
     */
    protected function sort($items = [])
    {
        $items = Collection::make($items)->sort(function (NodeInterface $a, NodeInterface $b) {
            $orderKey = $a->getOrderKeyName();
            if ($a->{$orderKey} == $b->{$orderKey}) {
                return 0;
            }

            return $a->{$orderKey} < $b->{$orderKey} ? -1 : 1;
        });

        return $items;
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
        return $this->getTreeNodes();
    }
}
