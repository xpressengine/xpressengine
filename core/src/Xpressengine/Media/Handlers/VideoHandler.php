<?php
/**
 * This file is video handler
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

namespace Xpressengine\Media\Handlers;

use Xpressengine\Media\Exceptions\WrongInstanceException;
use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Extensions\ExtensionInterface;
use Xpressengine\Media\Models\Media;
use Xpressengine\Media\Models\Video;
use Xpressengine\Media\Repositories\VideoRepository;
use Xpressengine\Storage\TempFileCreator;
use Xpressengine\Storage\File;

/**
 * Class VideoHandler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class VideoHandler extends AbstractHandler
{
    /**
     * Media reader instance
     *
     * @var \getID3
     */
    protected $reader;

    /**
     * TempFileCreator instance
     *
     * @var TempFileCreator
     */
    protected $temp;

    /**
     * Extension instance
     *
     * @var ExtensionInterface
     */
    protected $extension;

    /**
     * The time second for snapshot
     *
     * @var int
     */
    protected $fromSecond;

    /**
     * Constructor
     *
     * @param VideoRepository    $repo       VideoRepository instance
     * @param \getID3            $reader     Media reader instance
     * @param TempFileCreator    $temp       TempFileCreator instance
     * @param ExtensionInterface $extension  Extension instance
     * @param int                $fromSecond time second for snapshot
     */
    public function __construct(
        VideoRepository $repo,
        \getID3 $reader,
        TempFileCreator $temp,
        ExtensionInterface $extension,
        $fromSecond = 10
    ) {
        parent::__construct($repo);

        $this->reader = $reader;
        $this->temp = $temp;
        $this->extension = $extension;
        $this->fromSecond = $fromSecond;
    }

    /**
     * 미디어에서 사진 추출
     *
     * @param Media $media media instance
     * @return null|string 이미지 content
     * @throws WrongInstanceException
     */
    public function getPicture(Media $media)
    {
        if (!$media instanceof Video) {
            throw new WrongInstanceException();
        }

        $snapshot = $this->extension->getSnapshot($media->getContent(), $this->fromSecond);

        return $snapshot;
    }

    /**
     * media 객체로 반환
     *
     * @param File $file file instance
     * @return Video
     * @throws NotAvailableException
     */
    public function make(File $file)
    {
        if ($this->isAvailable($file->mime) !== true) {
            throw new NotAvailableException();
        }

        $video = $this->makeModel($file);
        if (!$video->meta) {
            list($audioData, $videoData, $playtime, $bitrate) = $this->extractInformation($video);

            $meta = $video->meta()->create([
                'audio' => $audioData,
                'video' => $videoData,
                'playtime' => $playtime,
                'bitrate' => $bitrate,
            ]);

            $video->setRelation('meta', $meta);
        }

        return $video;
    }

    /**
     * Extract file meta data
     *
     * @param Video $video video file instance
     * @return array
     */
    protected function extractInformation(Video $video)
    {
        $tmpFile = $this->temp->create($video->getContent());

        $info = $this->reader->analyze($tmpFile->getPathname());

        $tmpFile->destroy();

        if (isset($info['audio']['streams'])) {
            unset($info['audio']['streams']);
        }

        return [$info['audio'], $info['video'], $info['playtime_seconds'], $info['bitrate']];
    }

    /**
     * Set a extension
     *
     * @param ExtensionInterface $extension extension instance
     * @return void
     */
    public function setExtension(ExtensionInterface $extension)
    {
        $this->extension = $extension;
    }
}
