<?php
/**
 * This file is abstract command class
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Media\Commands;

use Xpressengine\Media\Coordinators\Dimension;

/**
 * 공통 command 기능
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
