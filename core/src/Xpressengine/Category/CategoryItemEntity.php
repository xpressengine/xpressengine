<?php
/**
 * This file is category item entity class.
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
namespace Xpressengine\Category;

use JsonSerializable;
use Xpressengine\Support\EntityTrait;
use Xpressengine\Support\Tree\NodeInterface;

/**
 * 카테고리를 구성하는 각 아이템 객체 클래스
 *
 * @category    Category
 * @package     Xpressengine\Category
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CategoryItemEntity implements NodeInterface, JsonSerializable
{
    use EntityTrait;

    /**
     * protected property when update
     *
     * @var array
     */
    protected $guarded = ['id', 'categoryId'];

    /**
     * Parent item
     *
     * @var NodeInterface
     */
    protected $parent;

    /**
     * Children items
     *
     * @var array
     */
    protected $children = [];

    /**
     * Current depth
     * @var int
     */
    protected $depth;

    /**
     * An array of ids
     * @var array
     */
    protected $breadCrumbs;

    /**
     * Set a parent item
     *
     * @param NodeInterface $node node object
     * @return void
     */
    public function setParent(NodeInterface $node)
    {
        $this->parent = $node;
    }

    /**
     * Return the parent node or null
     *
     * @return NodeInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add a child item
     *
     * @param NodeInterface $node node object
     * @return void
     */
    public function addChild(NodeInterface $node)
    {
        $this->children[] = $node;
    }

    /**
     * Return the child node items or empty array
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set children items
     *
     * @param array $children array of NodeInterface items
     * @return void
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    /**
     * Check having child and return the boolean result.
     *
     * @return bool
     */
    public function hasChild()
    {
        return !empty($this->children);
    }

    /**
     * set distance from ancestor
     *
     * @param int $depth distance from ancestor
     * @return void
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * get distance from ancestor
     *
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * set breadcrumbs
     *
     * @param array $ids item id array
     * @return void
     */
    public function setBreadcrumbs(array $ids)
    {
        $this->breadCrumbs = $ids;
    }

    /**
     * get breadcrumbs
     *
     * @return array
     */
    public function getBreadcrumbs()
    {
        return $this->breadCrumbs;
    }

    /**
     * setTreeNodePath
     *
     * @param string $path include tree path - hierarchy
     *
     * @return void
     */
    public function setTreeNodePath($path)
    {
        $breadCrumbs = explode(',', $path);
        $this->breadCrumbs = $breadCrumbs;
    }
//    /**
//     * Visible attribute returns to array
//     *
//     * @return array
//     */
//    public function toArray()
//    {
//        $array = $this->getAttributes();
//        $array['title'] = $array['word'];
//
//        return $array;
//    }

    /**
     * for api
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
