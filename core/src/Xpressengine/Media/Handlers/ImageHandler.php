<?php
/**
 * This file is image handler
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

use Xpressengine\Media\Commands\CommandInterface;
use Xpressengine\Media\Exceptions\WrongInstanceException;
use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Models\Image;
use Xpressengine\Media\Models\Media;
use Xpressengine\Media\Thumbnailer;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;

/**
 * Class ImageHandler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
     * Constructor
     *
     * @param Storage $storage Storage instance
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
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

        return $media->getContent();
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

        $name = implode('_', [
            $command->getName(),
            $command->getDimension()->getWidth() . 'x' . $command->getDimension()->getHeight(),
            hash('sha1', $content),
        ]);

        if ($originId !== null) {
            $file = File::find($originId);
            $parts = pathinfo($file->filename);
            if (isset($parts['extension']) && $parts['extension'] != '') {
                $name = sprintf('%s.%s', $name, $parts['extension']);
            }
        }
        $file = $this->storage->create(
            $content,
            $path ?: '',
            $name,
            $disk,
            $originId
        );

        return $this->make($file, ['type' => $command->getName(), 'code' => $code]);
    }

    /**
     * 각 미디어 타입에서 사용가능한 확장자 반환
     *
     * @return array
     */
    public function getAvailableMimes()
    {
        $class = $this->getModel();

        return $class::getMimes();
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
        if ($this->isAvailable($file->mime) !== true) {
            throw new NotAvailableException();
        }

        $image = $this->createModel($file);
        if (!$image->meta) {
            list($width, $height) = $this->extractDimension($image);

            $meta = $image->meta()->create(array_merge([
                'width' => $width,
                'height' => $height,
            ], $addInfo));

            $image->setRelation('meta', $meta);
        }

        return $image;
    }

    /**
     * Extract file meta data
     *
     * @param Image $image file instance
     * @return array
     */
    protected function extractDimension(Image $image)
    {
        return getimagesizefromstring($image->getContent());
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
     * Returns model class
     *
     * @return string
     */
    public function getModel()
    {
        return Image::class;
    }

    /**
     * Create model
     *
     * @param File $file file instance
     * @return Image
     */
    public function createModel(File $file)
    {
        $class = $this->getModel();

        return $class::make($file);
    }
}
