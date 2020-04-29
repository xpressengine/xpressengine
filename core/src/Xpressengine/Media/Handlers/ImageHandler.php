<?php
/**
 * This file is image handler
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

namespace Xpressengine\Media\Handlers;

use Xpressengine\Media\Commands\CommandInterface;
use Xpressengine\Media\Exceptions\WrongInstanceException;
use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Models\Image;
use Xpressengine\Media\Models\Media;
use Xpressengine\Media\Repositories\ImageRepository;
use Xpressengine\Media\Thumbnailer;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;

/**
 * Class ImageHandler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
     * @param ImageRepository $repo    ImageRepository instance
     * @param Storage         $storage Storage instance
     */
    public function __construct(ImageRepository $repo, Storage $storage)
    {
        parent::__construct($repo);

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
     * @param mixed            $option   disk option (ex. aws s3 'visibility: public')
     * @return Image
     */
    public function createThumbnails(
        $origin,
        CommandInterface $command,
        $code = null,
        $disk = null,
        $path = null,
        $originId = null,
        $option = []
    ) {
        $thumbnailer = $this->makeThumbnailer();
        $content = $thumbnailer->setOrigin($origin)->addCommand($command)->generate();

        $name = implode('_', [
            $command->getName(),
            $command->getDimension()->getWidth() . 'x' . $command->getDimension()->getHeight(),
            hash('sha1', $content),
        ]);

        if ($originId !== null) {
            $file = $this->storage->find($originId);
            $parts = pathinfo($file->filename);
            if (isset($parts['extension']) && $parts['extension'] != '') {
                $extension = $this->isAvailable($file->mime) ? $parts['extension'] : 'jpg';
                $name = sprintf('%s.%s', $name, $extension);
            }
        }
        $file = $this->storage->create(
            $content,
            $path ?: '',
            $name,
            $disk,
            $originId,
            null,
            $option
        );

        $image = $this->makeModel($file);
        $this->setMetaData($image, ['type' => $command->getName(), 'code' => $code]);

        return $image;
    }

    /**
     * media 객체로 반환
     *
     * @param File $file file instance
     * @return Image
     * @throws NotAvailableException
     */
    public function make(File $file)
    {
        if ($this->isAvailable($file->mime) !== true) {
            throw new NotAvailableException();
        }

        $image = $this->makeModel($file);
        $this->setMetaData($image);

        return $image;
    }

    /**
     * Set meta data for image
     *
     * @param Image $image   image instance
     * @param array $addInfo additional information
     * @return void
     */
    protected function setMetaData(Image $image, array $addInfo = [])
    {
        if (!$image->meta) {
            list($width, $height) = $this->extractDimension($image);

            $meta = $image->meta()->create(array_merge([
                'width' => $width,
                'height' => $height,
            ], $addInfo));

            $image->setRelation('meta', $meta);
        }
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
}
