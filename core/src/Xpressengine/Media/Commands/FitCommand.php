<?php
/**
 * This file is fit command
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

/**
 * crop & resize 를 수행하는 command
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class FitCommand extends AbstractCommand implements CommandInterface
{
    /**
     * fit position(center, left and right)
     *
     * @var string
     */
    protected $position = 'center';

    /**
     * Specific command name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getMethod();
    }

    /**
     * Executed command method name
     *
     * @return string
     */
    public function getMethod()
    {
        return 'fit';
    }

    /**
     * Arguments of executed method
     *
     * @return array
     */
    public function getExecArgs()
    {
        $width = $this->getDimension()->getWidth();
        $height = $this->getDimension()->getHeight();

        if ($width > $this->getOriginDimension()->getWidth()) {
            $width = $this->getOriginDimension()->getWidth();
        }
        if ($height > $this->getOriginDimension()->getHeight()) {
            $height = $this->getOriginDimension()->getHeight();
        }

        return [$width, $height, null, $this->position];
    }

    /**
     * Set fit position
     *
     * @param string $position fit position(center, left and right)
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
