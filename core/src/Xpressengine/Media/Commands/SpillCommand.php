<?php
/**
 * This file is letter command
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

namespace Xpressengine\Media\Commands;

use Xpressengine\Media\Coordinators\Dimension;

/**
 * 기준 사이즈에서 짧을 길이에 맞춰서 리사이징 command
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SpillCommand extends AbstractCommand implements CommandInterface
{
    /**
     * Specific command name
     *
     * @return string
     */
    public function getName()
    {
        return 'spill';
    }

    /**
     * Executed command method name
     *
     * @return string
     */
    public function getMethod()
    {
        return 'resize';
    }

    /**
     * Arguments of executed method
     *
     * @return array
     */
    public function getExecArgs()
    {
        return $this->remakeDimensionAsRatio(
            $this->originDimension->getWidth(),
            $this->originDimension->getHeight(),
            $this->dimension->getWidth(),
            $this->dimension->getHeight()
        );
    }

    /**
     * get new dimension by keeping the ratio
     *
     * @param int $srcWidth  original width
     * @param int $srcHeight original height
     * @param int $dstWidth  be resize width
     * @param int $dstHeight be resize height
     * @return array
     */
    private function remakeDimensionAsRatio($srcWidth, $srcHeight, $dstWidth, $dstHeight)
    {
        $width = $srcWidth;
        $height = $srcHeight;

        $ratioH = $dstHeight / $height;
        $ratioW = $dstWidth / $width;
        $ratio = max($ratioH, $ratioW);

        if ($ratio < 1) {
            $width = intval($ratio * $width);
            $height = intval($ratio * $height);
        }

        return [$width, $height];
    }
}
