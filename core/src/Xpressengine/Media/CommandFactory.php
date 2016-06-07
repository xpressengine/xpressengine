<?php
/**
 * This file is command factory for make thumbnail
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
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
