<?php
/**
 * This file is image handler
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

use Xpressengine\Media\Commands\CommandInterface;
use Xpressengine\Media\Exceptions\WrongInstanceException;
use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Meta;
use Xpressengine\Media\Repositories\ImageRepository;
use Xpressengine\Media\Spec\Image;
use Xpressengine\Media\Spec\Media;
use Xpressengine\Media\Thumbnailer;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;

/**
 * image handler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ImageHandler extends AbstractHandler
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
     * @var ImageRepository
     */
    protected $repo;

    /**
     * Available mime type
     *
     * @var array
     */
    protected $mimes = ['image/jpeg', 'image/png', 'image/gif', 'image/vnd.microsoft.icon', 'image/x-icon'];

    /**
     * Constructor
     *
     * @param Storage         $storage Storage instance
     * @param ImageRepository $repo    Repository instance
     */
    public function __construct(Storage $storage, ImageRepository $repo)
    {
        $this->storage = $storage;
        $this->repo = $repo;
    }

    /**
     * Get a thumbnail image
     *
     * @param Media  $media       media instance
     * @param string $type        thumbnail make type
     * @param string $dimension   dimension code
     * @param bool   $defaultSelf if set true, returns self when thumbnail not exists
     * @return null|Image|Media
     */
    public function getThumbnail(Media $media, $type, $dimension, $defaultSelf = true)
    {
        $meta = $this->repo->findByOption([
            'originId' => $media->getFile()->getId(),
            'type' => $type,
            'code' => $dimension
        ]);

        if ($meta !== null) {
            $file = $this->storage->get($meta->id);

            return $this->createModel($file, $meta);
        }

        return $defaultSelf === true ? $media : null;
    }

    /**
     * Get thumbnails
     *
     * @param Media       $media media instance
     * @param null|string $type  thumbnail make type
     * @return Image[]
     */
    public function getThumbnails(Media $media, $type = null)
    {
        $wheres = ['originId' => $media->getFile()->getId()];
        if ($type !== null) {
            $wheres = array_merge($wheres, ['type' => $type]);
        }

        $metas = $this->repo->fetch($wheres);

        $tmp = [];
        foreach ($metas as $meta) {
            $tmp[$meta->id] = $meta;
        }
        $metas = $tmp;

        $files = $this->storage->children($media->getFile());

        $result = [];
        foreach ($files as $file) {
            if (isset($metas[$file->getId()]) === true) {
                $result[] = $this->createModel($file, $metas[$file->getId()]);
            }
        }

        return $result;
    }

    /**
     * 미디어에서 사진 추출
     *
     * @param Media $media image instance
     * @return string 이미지 content
     * @throws WrongInstanceException
     */
    public function getPicture(Media $media)
    {
        if (!$media instanceof Image) {
            throw new WrongInstanceException();
        }

        return $this->storage->read($media->getFile());
    }

    /**
     * Create thumbnail images
     *
     * @param string           $origin   image content
     * @param CommandInterface $command  executable command
     * @param null|string      $code     dimension code
     * @param null|string      $disk     storage disk
     * @param null|string      $path     saved path
     * @param null|string      $originId origin file id
     * @return Image
     */
    public function createThumbnails(
        $origin,
        CommandInterface $command,
        $code = null,
        $disk = null,
        $path = null,
        $originId = null
    ) {
        $thumbnailer = $this->makeThumbnailer();
        $content = $thumbnailer->setOrigin($origin)->addCommand($command)->generate();

        $file = $this->storage->create(
            $content,
            $path ?: '',
            implode('_', [
                $command->getName(),
                $command->getDimension()->getWidth() . 'x' . $command->getDimension()->getHeight(),
                hash('sha1', $content),
            ]),
            $disk,
            $originId
        );

        return $this->make($file, ['type' => $command->getName(), 'code' => $code]);
    }

    /**
     * 섬네일 삭제
     *
     * @param Media $media media instance
     * @return int
     */
    public function removeThumbnails(Media $media)
    {
        return $this->repo->deleteByOriginId($media->id);
    }

    /**
     * media 객체로 반환
     *
     * @param File  $file    file instance
     * @param array $addInfo additional information
     * @return Image
     * @throws NotAvailableException
     */
    public function make(File $file, array $addInfo = [])
    {
        if ($this->isAvailable($file->getMime()) !== true) {
            throw new NotAvailableException();
        }

        if (!$meta = $this->repo->find($file->getId())) {
            $meta = $this->extractInformation($file);
            foreach ($addInfo as $key => $value) {
                $meta->{$key} = $value;
            }

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
        $content = $this->storage->read($file);
        list($realWidth, $realHeight) = getimagesizefromstring($content);

        $meta = new Meta();
        $meta->id = $file->getId();
        $meta->originId = $file->getOriginId(false);
        $meta->width = $realWidth;
        $meta->height = $realHeight;

        return $meta;
    }

    /**
     * Make thumbnailer instance
     *
     * @return Thumbnailer
     */
    protected function makeThumbnailer()
    {
        return new Thumbnailer();
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
     * @return Image
     */
    protected function createModel(File $file, Meta $meta)
    {
        return new Image($file, $meta);
    }
}
