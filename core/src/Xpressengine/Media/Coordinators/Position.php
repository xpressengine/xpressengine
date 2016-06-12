<?php
/**
 * This file is position class
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media\Coordinators;

/**
 * 좌표 지정 객체
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Position
{
    /**
     * top position
     *
     * @var int
     */
    protected $top;

    /**
     * left position
     *
     * @var int
     */
    protected $left;

    /**
     * Constructor
     *
     * @param int $top  top position
     * @param int $left left position
     */
    public function __construct($top, $left)
    {
        $this->top = $top;
        $this->left = $left;
    }

    /**
     * top position
     *
     * @return int
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * left position
     *
     * @return int
     */
    public function getLeft()
    {
        return $this->left;
    }
}
