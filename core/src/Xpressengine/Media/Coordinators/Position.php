<?php
/**
 * This file is position class
 *
 * PHP version 7
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media\Coordinators;

/**
 * 좌표 지정 객체
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
