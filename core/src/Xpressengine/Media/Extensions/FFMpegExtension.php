<?php
/**
 * This file is FFMpeg extension class
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

namespace Xpressengine\Media\Extensions;

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Xpressengine\Storage\TempFileCreator;

/**
 * FFMpeg extension 기능을 이용
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class FFMpegExtension implements ExtensionInterface
{
    /**
     * FFMpeg instance
     *
     * @var FFMpeg
     */
    protected $ffmpeg;

    /**
     * TempFileCreator instance
     *
     * @var TempFileCreator
     */
    protected $temp;

    /**
     * Constructor
     *
     * @param FFMpeg          $ffmpeg FFMpeg instance
     * @param TempFileCreator $temp   TempFileCreator instance
     */
    public function __construct(FFMpeg $ffmpeg, TempFileCreator $temp)
    {
        $this->ffmpeg = $ffmpeg;
        $this->temp = $temp;
    }

    /**
     * 영상에서 snapshot 추출
     *
     * @param string $content    media content
     * @param int    $fromSecond 영상에서의 시간(초 단위)
     * @return string
     */
    public function getSnapshot($content, $fromSecond = 10)
    {
        $videoFile = $this->temp->create($content);
        $imgPathname = $this->temp->getTempPathname();

        $video = $this->ffmpeg->open($videoFile->getPathname());
        $video->frame(TimeCode::fromSeconds($fromSecond))->save($imgPathname);

        $imageContent = file_get_contents($imgPathname);

        $videoFile->destroy();
        @unlink($imgPathname);

        return $imageContent;
    }
}
