<?php
/**
 * NodeInterface Interface
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

/**
 * Interface NodeInterface
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @property string id
 * @property string title
 * @property string parentId
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
interface NodeInterface
{
    /**
     * Get the unique identifier for the node
     *
     * @return string|int
     */
    public function getNodeIdentifier();

    /**
     * Get the unique identifier name for the node
     *
     * @return string
     */
    public function getNodeIdentifierName();

    /**
     * Get the parent identifier for the node
     *
     * @return string|int
     */
    public function getParentNodeIdentifier();

    /**
     * Set parent node
     *
     * @param NodeInterface $node parent node
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
     * Add child node
     *
     * @param NodeInterface $node child node
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
     * Set child nodes
     *
     * @param NodeInterface[] $children children node interfaces
     * @return void
     */
    public function setChildren($children = []);

    /**
     * Check having child and return the boolean result.
     *
     * @return bool
     */
    public function hasChild();

    /**
     * get breadcrumbs
     *
     * @return array
     */
    public function getBreadcrumbs();

    /**
     * Get the order key name for model
     *
     * @return string
     */
    public function getOrderKeyName();
}
