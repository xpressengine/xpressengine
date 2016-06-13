<?php
/**
 * This file is command interface
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

namespace Xpressengine\Media\Commands;

use Xpressengine\Media\Coordinators\Dimension;

/**
 * command 기능을 정의
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
interface CommandInterface
{
    /**
     * Specific command name
     *
     * @return string
     */
    public function getName();

    /**
     * Executed command method name
     *
     * @return string
     */
    public function getMethod();

    /**
     * Set a dimension
     *
     * @param Dimension $dimension Dimension interface
     * @return void
     */
    public function setDimension(Dimension $dimension);

    /**
     * Set origin dimension
     *
     * @param Dimension $dimension dimension instance
     * @return void
     */
    public function setOriginDimension(Dimension $dimension);

    /**
     * Get a dimension
     *
     * @return Dimension
     */
    public function getDimension();

    /**
     * Get origin dimension
     *
     * @return Dimension
     */
    public function getOriginDimension();

    /**
     * Arguments of executed method
     *
     * @return array
     */
    public function getExecArgs();
}
