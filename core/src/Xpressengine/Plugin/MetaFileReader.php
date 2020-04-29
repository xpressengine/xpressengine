<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin;

/**
 * 플러그인 메타파일(composer.json)리더.
 * json 형태의 플러그인의 메타파일을 읽어들인 다음, 디코딩한 다음 반환한다.
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MetaFileReader
{
    /**
     * @var $fileName file의 기본 파일명
     */
    protected $fileName;

    /**
     * MetaFileReader constructor.
     *
     * @param string $fileName 기본파일명
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * 주어진 path에 위치한 fileName을 가진 파일의 데이터를 읽어들여 object 형태로 반환한다.
     *
     * @param string $path     디렉토리 경로
     * @param string $fileName 파일명, 파일명이 null일 경우 기본 파일명을 사용한다.
     *
     * @return mixed
     */
    public function read($path, $fileName = null)
    {
        if ($fileName === null) {
            $fileName = $this->fileName;
        }

        $fileContent = $this->getFileContents($path.'/'.$fileName);
        return json_decode($fileContent, true);
    }

    /**
     * getFileContents
     *
     * @param string $path file path
     *
     * @return string
     */
    protected function getFileContents($path)
    {
        return file_get_contents($path);
    }
}
