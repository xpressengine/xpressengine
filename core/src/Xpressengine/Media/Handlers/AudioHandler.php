<?php
/**
 * This file is audio handler
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

use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Exceptions\WrongInstanceException;
use Xpressengine\Media\Extensions\ExtensionInterface;
use Xpressengine\Media\Models\Media;
use Xpressengine\Media\Models\Audio;
use Xpressengine\Media\Repositories\AudioRepository;
use Xpressengine\Storage\Storage;
use Xpressengine\Storage\TempFileCreator;
use Xpressengine\Storage\File;

/**
 * Class AudioHandler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class AudioHandler extends AbstractHandler
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
     * Storage instance
     *
     * @var Storage
     */
    protected $storage;

    /**
     * Constructor
     *
     * @param AudioRepository $repo   AudioRepository instance
     * @param \getID3         $reader Media reader instance
     * @param TempFileCreator $temp   TempFileCreator instance
     * @param ExtensionInterface $extension  Extension instance
     * @param Storage         $storage Storage instance
     */
    public function __construct(AudioRepository $repo, \getID3 $reader, TempFileCreator $temp, ExtensionInterface $extension, Storage $storage)
    {
        parent::__construct($repo);

        $this->reader = $reader;
        $this->temp = $temp;
        $this->extension = $extension;
        $this->storage = $storage;
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
     * 미디어에서 jsonfile 생성
     *
     * @param Media $media media instance
     * @return string jsonfile content
     */
    public function getJsonFile(Media $media)
    {
        if (!$media instanceof Audio) {
            throw new WrongInstanceException();
        }
        $waveform = $this->extension->getWaveform($media);

        return $waveform;
    }

    /**
     * Create waveform file
     *
     * @param string           $origin   waveform json file content
     * @param null|string      $disk     storage disk
     * @param null|string      $path     saved path
     * @param null|string      $originId origin file id
     * @param mixed            $option   disk option (ex. aws s3 'visibility: public')
     * @return File
     */
    public function createWaveform(
        $origin,
        $disk = null,
        $path = null,
        $originId = null,
        $option = []
    ) {
        if ($originId !== null) {
            $file = $this->storage->find($originId);
            $parts = pathinfo($file->filename);

            $name = '';
            if (isset($parts['extension']) && $parts['extension'] != '') {
                //$extension = $this->isAvailable($file->mime) ? $parts['extension'] : 'jpg';
                //$name = sprintf('%s.%s', $name, $extension);
                $name = sprintf('%s%s.%s', $parts['filename'], '-peaks', 'json');
            }
        }

        $file = $this->storage->create(
            $origin,
            $path ?: '',
            $name,
            $disk,
            $originId,
            null,
            $option
        );

        //
        return $file;
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
        if ($this->isAvailable($file->mime) !== true) {
            throw new NotAvailableException();
        }

        $audio = $this->makeModel($file);
        if (!$audio->meta) {
            list($audioData, $playtime, $bitrate) = $this->extractInformation($audio);

            $meta = $audio->meta()->create([
                'audio' => $audioData,
                'playtime' => $playtime,
                'bitrate' => $bitrate,
            ]);

            $audio->setRelation('meta', $meta);
        }

        return $audio;
    }

    /**
     * Extract file meta data
     *
     * @param Audio $audio audio file instance
     * @return array
     */
    protected function extractInformation(Audio $audio)
    {
        $tmpFile = $this->temp->create($audio->getContent());

        $info = $this->reader->analyze($tmpFile->getPathname());

        $tmpFile->destroy();

        if (isset($info['audio']['streams'])) {
            unset($info['audio']['streams']);
        }

        if (isset($info['playtime_seconds']) == false) {
            $info['playtime_seconds'] = 60;
        }

        if (isset($info['bitrate']) == false) {
            $info['bitrate'] = 128000;
        }

        return [$info['audio'], $info['playtime_seconds'], $info['bitrate']];
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
