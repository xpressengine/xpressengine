<?php
/**
 * This file is management Media package
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

namespace Xpressengine\Media;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Xpressengine\Media\Coordinators\Dimension;
use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Exceptions\UnknownTypeException;
use Xpressengine\Media\Models\Media;
use Xpressengine\Media\Models\Image;
use Xpressengine\Storage\File;
use Xpressengine\Media\Handlers\MediaHandler;
use Xpressengine\Storage\Storage;

/**
 * Class MediaManager
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class MediaManager
{
    /**
     * Storage instance
     *
     * @var Storage
     */
    protected $storage;

    /**
     * CommandFactory instance
     *
     * @var CommandFactory
     */
    protected $factory;

    /**
     * config data
     *
     * @var array
     */
    protected $config = [];

    /**
     * media handlers
     *
     * @var MediaHandler[]
     */
    protected $handlers = [];

    /**
     * Constructor
     *
     * @param Storage        $storage Storage instance
     * @param CommandFactory $factory CommandFactory instance
     * @param array          $config  config data
     */
    public function __construct(Storage $storage, CommandFactory $factory, array $config)
    {
        $this->storage = $storage;
        $this->factory = $factory;
        $this->config = $config;
    }

    /**
     * Returns handler
     *
     * @param string $type media type
     * @return MediaHandler
     * @throws UnknownTypeException
     */
    public function getHandler($type)
    {
        if (isset($this->handlers[$type]) !== true) {
            throw new UnknownTypeException();
        }

        return $this->handlers[$type];
    }

    /**
     * Returns handler by storage File instance
     *
     * @param File $file file instance
     * @return MediaHandler
     * @throws UnknownTypeException
     */
    public function getHandlerByFile(File $file)
    {
        if (!$type = $this->getFileType($file)) {
            throw new UnknownTypeException();
        }

        return $this->getHandler($type);
    }

    /**
     * 파일이 특정 미디어 타입과 매칭된다며 해당 타입 반환
     *
     * @param File $file file instance
     * @return string|null
     */
    public function getFileType(File $file)
    {
        foreach ($this->handlers as $type => $handler) {
            if ($handler->isAvailable($file->mime) === true) {
                return $type;
            }
        }

        return null;
    }

    /**
     * Returns handler by storage Media instance
     *
     * @param Media $media media instance
     * @return MediaHandler
     */
    public function getHandlerByMedia(Media $media)
    {
        return $this->getHandler($media->getType());
    }

    /**
     * 파일을 타입에 맞는 미디어 객체로 재생성하여 반환
     *
     * @param File $file file instance
     * @return Media
     * @throws NotAvailableException
     */
    public function make(File $file)
    {
        return $this->getHandlerByFile($file)->make($file);
    }

    /**
     * 파일을 미디어 타입으로 변환, 메타데이터는 생성하지 않음
     *
     * @param File $file file instance
     * @return Media
     */
    public function cast(File $file)
    {
        return $this->getHandlerByFile($file)->makeModel($file);
    }

    /**
     * 파일이 미디어 파일인지 확인
     *
     * @param File $file file instance
     * @return bool
     */
    public function is(File $file)
    {
        foreach ($this->handlers as $type => $handler) {
            if ($handler->isAvailable($file->mime) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * 미디어 삭제
     *
     * @param Media $media media instance
     * @return bool
     */
    public function delete(Media $media)
    {
        $this->metaDelete($media);

        return $this->storage->delete($media);
    }

    /**
     * 미디어 삭제
     *
     * @param Media $media media instance
     * @return bool
     *
     * @deprecated since beta.17. Use delete instead.
     */
    public function remove(Media $media)
    {
        return $this->delete($media);
    }

    /**
     * Meta data 삭제
     *
     * @param Media $media media instance
     * @return void
     */
    public function metaDelete(Media $media)
    {
        if ($media->meta) {
            $media->meta->delete();
        }
    }

    /**
     * Meta data 삭제
     *
     * @param Media $media media instance
     * @return void
     *
     * @deprecated since beta.17. Use metaDelete instead.
     */
    public function metaRemove(Media $media)
    {
        $this->metaDelete($media);
    }

    /**
     * 섬네일 생성
     *
     * @param Media       $media      media instance
     * @param string|null $type       섬네일 생성 방식
     * @param array|null  $dimensions 섬네일 크기
     * @return Collection|Image[]
     */
    public function createThumbnails(Media $media, $type = null, array $dimensions = null)
    {
        $type = strtolower($type ?: $this->config['type']);
        $dimensions = $dimensions ?: $this->config['dimensions'];
        $handler = $this->getHandlerByMedia($media);

        if (!$content = $handler->getPicture($media)) {
            return [];
        }

        $thumbnails = [];
        foreach ($dimensions as $code => $dimension) {
            $command = $this->factory->make($type);
            $command->setDimension(new Dimension($dimension['width'], $dimension['height']));

            $thumbnails[] = $this->getHandler(Media::TYPE_IMAGE)
                ->createThumbnails(
                    $content,
                    $command,
                    $code,
                    $this->config['disk'],
                    $this->config['path'],
                    $media->getOriginKey()
                );
        }

        return new Collection($thumbnails);
    }

    /**
     * 동적으로 생성된 미디어 파일 반환
     *
     * @param Media $media media instance
     * @return Collection|Media[]
     */
    public function getDerives(Media $media)
    {
        $files = $media->getRawDerives();

        foreach ($files as $key => $file) {
            $files[$key] = $this->is($file) ? $this->make($file) : null;
        }

        return $files->filter();
    }

    /**
     * 미디어 핸들러를 추가, 변경하여 기능 확장
     *
     * is() method 를 통해 파일이 미디어 인지 판별할 수 있어야 하므로
     * 각각의 handler 들은 활성화된 상태로 전달 받도록 함
     *
     * @param string       $type    media type
     * @param MediaHandler $handler media handler
     * @return void
     */
    public function extend($type, MediaHandler $handler)
    {
        $this->handlers[$type] = $handler;
    }

    /**
     * __call
     *
     * @param string     $name      method name
     * @param array|null $arguments arguments
     * @return MediaHandler|null
     */
    public function __call($name, $arguments)
    {
        $name = Str::singular($name);

        if (!array_key_exists($name, $this->handlers)) {
            return null;
        }

        return $this->handlers[$name];
    }
}
