<?php
/**
 * This file is audio handler
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

use Xpressengine\Media\Exceptions\NotAvailableException;
use Xpressengine\Media\Models\Media;
use Xpressengine\Media\Models\Audio;
use Xpressengine\Media\Repositories\AudioRepository;
use Xpressengine\Storage\TempFileCreator;
use Xpressengine\Storage\File;

/**
 * Class AudioHandler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
     * Constructor
     *
     * @param AudioRepository $repo   AudioRepository instance
     * @param \getID3         $reader Media reader instance
     * @param TempFileCreator $temp   TempFileCreator instance
     */
    public function __construct(AudioRepository $repo, \getID3 $reader, TempFileCreator $temp)
    {
        parent::__construct($repo);

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

        return [$info['audio'], $info['playtime_seconds'], $info['bitrate']];
    }
}
