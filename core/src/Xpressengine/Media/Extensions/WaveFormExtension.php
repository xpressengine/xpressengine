<?php
/**
 * This file is audiowaveform extension class
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

namespace Xpressengine\Media\Extensions;

use Symfony\Component\Process\Process;
use Xpressengine\Media\Models\Media;
use Xpressengine\Storage\TempFileCreator;

/**
 * audio WaveForm extension 기능을 이용
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

class WaveFormExtension implements ExtensionInterface
{
    /**
     * audioExtensions waveform config
     *
     * @var array
     */
    protected $config;

    /**
     * TempFileCreator instance
     *
     * @var TempFileCreator
     */
    protected $temp;

    /**
     * Constructor
     *
     * @param array $config config array
     */
    public function __construct($config, TempFileCreator $temp)
    {
        $this->config = $config;
        $this->temp = $temp;
    }

    /**
     * 영상에서 snapshot 추출
     *
     * @param string $content    media content
     * @param int    $fromSecond 영상에서의 시간(초 단위)
     * @return null
     */
    public function getSnapshot($content, $fromSecond = 10)
    {
        return null;
    }

    /**
     * 오디오에서 waveform -peak.json file 생성
     *
     * @param Media $media media instance
     * @return null|string
     */
    public function getWaveform($media)
    {
        $jsonPathname = $this->temp->getTempPathname();

        /* 오디오 파일로 process 실행 시켜 [originfilename]-peaks.json 생성 */
        $audioPathName = $media->getPathname();
        $jsonFileName = $this->getJsonFileName($media->getAttribute('filename'));
        $process = new Process(
            sprintf('audiowaveform -i %s -o %s --bits 8 --pixels-per-second 500',
                storage_path('app/public/media/'.$audioPathName),
                $jsonPathname.$jsonFileName
            )
        );

        $process->run(); // to run Sync
        // $process->start(); // to run Async

        /* TODO process 실패 처리 */
        if (!$process->isSuccessful()) {
            \Log::info($process->getErrorOutput());
            //throw new \RuntimeException($process->getErrorOutput());
        } else {
            /* -peack.json 파일을 python 실행 시켜 재생성 */
            // commandFilePath 위치는 webroot 아래
            $process2 = new Process(sprintf('python %s %s', $this->config['commandFilePath'], $jsonPathname.$jsonFileName));
            $process2->run();
            if (!$process2->isSuccessful()) {
                \Log::info($process2->getErrorOutput());
                //throw new \RuntimeException($process2->getErrorOutput());
            } else {
                /* json 파일을 읽어서 return */
                $jsonContent = file_get_contents($jsonPathname.$jsonFileName);
                @unlink($jsonPathname.$jsonFileName);

                return $jsonContent;
            }
        }
        return null;
    }

    private function getJsonFileName($pathname)
    {
        return substr($pathname, 0, strpos($pathname, '.')).'-peaks.json';
    }


}
