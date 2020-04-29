<?php
/**
 * This file is command factory for make thumbnail
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

namespace Xpressengine\Media;

use Xpressengine\Media\Commands\CommandInterface;
use Xpressengine\Media\Exceptions\UnknownCommandException;

/**
 * 섬네일 생성시 사용되는 command 를 제공
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CommandFactory
{
    /**
     * Returns command
     *
     * @param string $type command type
     * @return CommandInterface
     * @throws UnknownCommandException
     */
    public function make($type)
    {
        if (class_exists('\\Xpressengine\\Media\\Commands\\' . ucfirst($type) . 'Command')) {
            $class = '\\Xpressengine\\Media\\Commands\\' . ucfirst($type) . 'Command';
            return new $class();
        }

        throw new UnknownCommandException(['name' => $type]);
    }
}
