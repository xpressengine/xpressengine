<?php
/**
 * This file is video handler
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
namespace Xpressengine\Media\Handlers;

use Xpressengine\Media\Exceptions\InstanceNotMatchException;
use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Extensions\ExtensionInterface;
use Xpressengine\Media\Meta;
use Xpressengine\Media\Repositories\VideoRepository;
use Xpressengine\Media\Spec\Media;
use Xpressengine\Media\Spec\Image;
use Xpressengine\Media\Spec\Video;
use Xpressengine\Media\TempStorage;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;

/**
 * video handler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class VideoHandler extends AbstractHandler
{
    /**
     * Storage instance
     *
     * @var Storage
     */
    protected $storage;

    /**
     * Repository instance
     *
     * @var VideoRepository
     */
    protected $repo;

    /**
     * Media reader instance
     *
     * @var \getID3
     */
    protected $reader;

    /**
     * TempStorage instance
     *
     * @var TempStorage
     */
    protected $temp;

    /**
     * Extension instance
     *
     * @var ExtensionInterface
     */
    protected $extension;

    /**
     * Available mime type
     *
     * @var array
     */
    protected $mimes = [
        'video/x-flv', 'video/mp4', 'application/x-mpegURL', 'video/MP2T',
        'video/3gpp', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv',
        'video/ogg', 'video/webm'
    ];

    /**
     * Constructor
     *
     * @param Storage            $storage   Storage instance
     * @param VideoRepository    $repo      Repository instance
     * @param \getID3            $reader    Media reader instance
     * @param TempStorage        $temp      TempStorage instance
     * @param ExtensionInterface $extension Extension instance
     */
    public function __construct(
        Storage $storage,
        VideoRepository $repo,
        \getID3 $reader,
        TempStorage $temp,
        ExtensionInterface $extension
    ) {
        $this->storage = $storage;
        $this->repo = $repo;
        $this->reader = $reader;
        $this->temp = $temp;
        $this->extension = $extension;
    }

    /**
     * 미디어에서 사진 추출
     *
     * @param Media $media media instance
     * @return null|string 이미지 content
     * @throws InstanceNotMatchException
     */
    public function getPicture(Media $media)
    {
        if (!$media instanceof Video) {
            throw new InstanceNotMatchException();
        }

        // todo: 추출할 시간 정보를 별도로 입력받도록 처리할지?
        $snapshot = $this->extension->getSnapshot($this->storage->read($media->getFile()));

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
        if ($this->isAvailable($file->getMime()) !== true) {
            throw new NotAvailableException();
        }

        if (!$meta = $this->repo->find($file->getId())) {
            $meta = $this->extractInformation($file);
            $meta->dataEncode(Video::getJsonType());

            $meta = $this->repo->insert($meta);
        }

        return $this->createModel($file, $meta);
    }

    /**
     * Extract file meta data
     *
     * @param File $file file instance
     * @return Meta
     */
    protected function extractInformation(File $file)
    {
        $meta = new Meta();
        $meta->id = $file->getId();
        $meta->originId = $file->getOriginId(false);

        $tmpPathname = $this->temp->getTempPathname();
        $this->temp->createFile($tmpPathname, $this->storage->read($file));

        $info = $this->reader->analyze($tmpPathname);

        $this->temp->remove($tmpPathname);

        if (isset($info['audio']['streams'])) {
            unset($info['audio']['streams']);
        }

        $meta->audio = $info['audio'];
        $meta->video = $info['video'];
        $meta->playtime = $info['playtime_seconds'];
        $meta->bitrate = $info['bitrate'];

        return $meta;
    }

    /**
     * 미디어 삭제
     *
     * @param Media $media media instance
     * @return void
     */
    public function remove(Media $media)
    {
        $this->repo->delete($media->getMeta());
    }

    /**
     * Create model
     *
     * @param File $file file instance
     * @param Meta $meta meta instance
     * @return Video
     */
    protected function createModel(File $file, Meta $meta)
    {
        return new Video($file, $meta);
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
