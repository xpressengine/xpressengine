<?php
/**
 * This file is FFMpeg extension class
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
namespace Xpressengine\Media\Extensions;

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Xpressengine\Media\TempStorage;

/**
 * FFMpeg extension 기능을 이용
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
     * TempStorage instance
     *
     * @var TempStorage
     */
    protected $temp;

    /**
     * Constructor
     *
     * @param FFMpeg      $ffmpeg FFMpeg instance
     * @param TempStorage $temp   TempStorage instance
     */
    public function __construct(FFMpeg $ffmpeg, TempStorage $temp)
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
        $tmpPathname = $this->temp->getTempPathname();
        $tmpImgPathname = $this->temp->getTempPathname();

        $this->temp->createFile($tmpPathname, $content);

        $video = $this->ffmpeg->open($tmpPathname);
        $video->frame(TimeCode::fromSeconds($fromSecond))->save($tmpImgPathname);

        $imageContent = file_get_contents($tmpImgPathname);

        $this->temp->remove($tmpPathname);
        $this->temp->remove($tmpImgPathname);

        return $imageContent;
    }
}
