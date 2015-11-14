<?php
/**
 * NodeInterface Interface
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

/**
 * Interface NodeInterface
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @property string id
 * @property string title
 * @property string parentId
 */
interface NodeInterface
{

    /**
     * @param NodeInterface $node parent node
     *
     * @return void
     */
    public function setParent(NodeInterface $node);

    /**
     * Return the parent node or null
     *
     * @return NodeInterface
     */
    public function getParent();

    /**
     * @param NodeInterface $node child node
     *
     * @return void
     */
    public function addChild(NodeInterface $node);

    /**
     * Return the child node items or empty array
     *
     * @return array
     */
    public function getChildren();

    /**
     * @param NodeInterface[] $children children node interfaces
     *
     * @return void
     */
    public function setChildren(array $children);

    /**
     * Check having child and return the boolean result.
     *
     * @return bool
     */
    public function hasChild();

    /**
     * set distance from ancestor
     *
     * @param int $depth distance from ancestor
     *
     * @return void
     */
    public function setDepth($depth);

    /**
     * get distance from ancestor
     *
     * @return int
     */
    public function getDepth();

    /**
     * set breadcrumbs
     *
     * @param array $ids term id array
     *
     * @return void
     */
    public function setBreadcrumbs(array $ids);

    /**
     * get breadcrumbs
     *
     * @return array
     */
    public function getBreadcrumbs();

    /**
     * setTreeNodePath
     *
     * @param string $path include tree path - hierarchy
     *
     * @return void
     */
    public function setTreeNodePath($path);
}
