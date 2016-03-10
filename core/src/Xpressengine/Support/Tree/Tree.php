<?php
namespace Xpressengine\Support\Tree;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Database\Eloquent\Collection;

class Tree implements ArrayAccess, JsonSerializable
{
    /**
     * @var Collection $rawNodes Node[]
     */
    protected $rawNodes;
    /**
     * @var Collection $treeNodes Node[]
     */
    protected $treeNodes;

    /**
     * @param Node[] $rawNodes nodes
     */
    public function __construct($rawNodes)
    {
        $this->rawNodes = Collection::make($rawNodes)->getDictionary();
        $this->arrange();
    }

    public static function make($rawNodes)
    {
        return new static($rawNodes);
    }

    /**
     * getRawNodes
     *
     * @return Collection Node[]
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
     * @param Node $node nodes
     *
     * @return $this
     */
    public function add(Node $node)
    {
        $this->rawNodes[$node->getKey()] = $node;
        $parentId = $node->{$node->getParentIdName()};
        if ($parentId) {
            $parent = $this->rawNodes[$parentId];
            $parent->addChild($node);
            $parent->setRawChildren($this->sort($parent->getChildren()));
            $node->setParent($this->rawNodes[$parentId]);
        } else {
            $this->treeNodes[$node->getKey()] = $node;
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

        foreach ($nodes as $node) {
            $parentId = $node->{$node->getParentIdName()};
            if (isset($nodes[$parentId])) {
                $nodes[$parentId]->addChild($node);
                $node->setParent($nodes[$parentId]);
            } else {
                $root[$node->getKey()] = $node;
            }
        }
        $this->treeNodes = $this->fullSort($root);
    }

    protected function fullSort($tree = [])
    {
        /** @var Node $item */
        foreach ($tree as $item) {
            if ($item->hasChild()) {
                $item->setRawChildren($this->fullSort($item->getChildren()));
            }
        }

        return $this->sort($tree);
    }

    /**
     * sort node tree
     *
     * @param Node[] $items nodes
     *
     * @return array
     */
    protected function sort($items = [])
    {
        $items = Collection::make($items);
        $items->sort(function (Node $a, Node $b) {
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
