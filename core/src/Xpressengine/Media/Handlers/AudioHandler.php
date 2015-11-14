<?php
/**
 * This file is audio handler
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

use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Meta;
use Xpressengine\Media\Repositories\AudioRepository;
use Xpressengine\Media\Spec\Media;
use Xpressengine\Media\Spec\Audio;
use Xpressengine\Media\TempStorage;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;

/**
 * audio handler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class AudioHandler extends AbstractHandler
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
     * @var AudioRepository
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
     * Available mime type
     *
     * @var array
     */
    protected $mimes = ['audio/mpeg', 'audio/ogg', 'audio/wav'];

    /**
     * Constructor
     *
     * @param Storage         $storage Storage instance
     * @param AudioRepository $repo    Repository instance
     * @param \getID3         $reader  Media reader instance
     * @param TempStorage     $temp    TempStorage instance
     */
    public function __construct(Storage $storage, AudioRepository $repo, \getID3 $reader, TempStorage $temp)
    {
        $this->storage = $storage;
        $this->repo = $repo;
        $this->reader = $reader;
        $this->temp = $temp;
    }

    /**
     * 미디어에서 사진 추출
     *
     * @param Media $media audio instance
     * @return null
     */
    public function getPicture(Media $media)
    {
        return null;
    }

    /**
     * media 객체로 반환
     *
     * @param File $file file instance
     * @return Audio
     * @throws NotAvailableException
     */
    public function make(File $file)
    {
        if ($this->isAvailable($file->getMime()) !== true) {
            throw new NotAvailableException();
        }

        if (!$meta = $this->repo->find($file->getId())) {
            $meta = $this->extractInformation($file);
            $meta->dataEncode(Audio::getJsonType());

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
     * @return Audio
     */
    protected function createModel(File $file, Meta $meta)
    {
        return new Audio($file, $meta);
    }
}
