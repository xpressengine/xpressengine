<?php
/**
 * This file is Thumbnail maker
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

use Intervention\Image\ImageManager;
use Xpressengine\Media\Commands\CommandInterface;
use Xpressengine\Media\Exceptions\PropertyNotSetException;
use Xpressengine\Media\Coordinators\Dimension;

/**
 * 이미지 섬네일 생성 처리
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Thumbnailer
{
    /**
     * ImageManager instance
     *
     * @var ImageManager
     */
    protected static $manager;

    /**
     * Origin image content
     *
     * @var string
     */
    protected $image;

    /**
     * Be executed commands
     *
     * @var CommandInterface[]
     */
    protected $commands = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * Set Intervention image manager
     *
     * @param ImageManager $manager ImageManager instance
     * @return void
     */
    public static function setManager(ImageManager $manager)
    {
        static::$manager = $manager;
    }

    /**
     * Get Intervention image manager
     *
     * @return ImageManager $manager ImageManager instance
     */
    public static function getManager()
    {
        return static::$manager;
    }

    /**
     * Set target image
     *
     * @param string $image image content
     * @return $this
     */
    public function setOrigin($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Add command
     *
     * @param CommandInterface $command command instance
     * @return $this
     */
    public function addCommand(CommandInterface $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Generate thumbnail image
     *
     * @return string image content
     * @throws PropertyNotSetException
     */
    public function generate()
    {
        if (count($this->commands) < 1 || $this->image === null) {
            throw new PropertyNotSetException();
        }

        $info = getimagesizefromstring($this->image);

        $thumb = $this->image;
        foreach ($this->commands as $command) {
            $origin = new Dimension($info[0], $info[1]);
            $command->setOriginDimension($origin);

            $itvImage = call_user_func_array(
                [static::$manager->make($thumb), $command->getMethod()],
                $command->getExecArgs()
            );

            $thumb = $itvImage->encode()->getEncoded();
        }

        return $thumb;
    }
}
