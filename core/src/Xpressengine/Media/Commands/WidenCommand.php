<?php
/**
 * This file is widen command
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

/**
 * 가로기준 리사이징 command
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class WidenCommand extends AbstractCommand implements CommandInterface
{
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
        return 'widen';
    }

    /**
     * Arguments of executed method
     *
     * @return array
     */
    public function getExecArgs()
    {
        return [$this->dimension->getWidth()];
    }
}
