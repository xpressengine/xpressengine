<?php
/**
 * This file is dimension class
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
 * 가로 세로 크기 객체
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Dimension
{
    /**
     * 가로 크기
     *
     * @var int
     */
    protected $width;

    /**
     * 세로 크기
     *
     * @var int
     */
    protected $height;

    /**
     * Constructor
     *
     * @param int $width  가로 크기
     * @param int $height 세로 크기
     */
    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * 가로 크기
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * 세로 크기
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
}
