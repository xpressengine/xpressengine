<?php
/**
 * This file is abstract command class
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
 * 공통 command 기능
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class AbstractCommand
{
    /**
     * Dimension interface
     *
     * @var Dimension
     */
    protected $dimension;

    /**
     * Origin dimension
     *
     * @var Dimension
     */
    protected $originDimension;

    /**
     * Set a dimension
     *
     * @param Dimension $dimension Dimension interface
     * @return void
     */
    public function setDimension(Dimension $dimension)
    {
        $this->dimension = $dimension;
    }

    /**
     * Set origin dimension
     *
     * @param Dimension $dimension dimension instance
     * @return void
     */
    public function setOriginDimension(Dimension $dimension)
    {
        $this->originDimension = $dimension;
    }

    /**
     * Get a dimension
     *
     * @return Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Get a dimension
     *
     * @return Dimension
     */
    public function getOriginDimension()
    {
        return $this->originDimension;
    }
}
