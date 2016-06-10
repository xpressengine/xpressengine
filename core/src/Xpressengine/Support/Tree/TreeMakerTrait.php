<?php
/**
 * This file is trait for tree makes.
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
 * Trait TreeMakerTrait
 *
 * @category    Support
 * @package     Xpressengine\Support
 */
trait TreeMakerTrait
{
    /**
     * Make Tree instance
     *
     * @param array $nodes node items
     * @return Tree
     */
    protected function makeTree($nodes = [])
    {
        return Tree::make($nodes);
    }
}
