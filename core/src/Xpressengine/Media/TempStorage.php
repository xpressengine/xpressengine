<?php
/**
 * This file is temporary storage class
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
namespace Xpressengine\Media;

/**
 * 파일 처리를 위한 임시 저장 처리
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class TempStorage
{
    /**
     * 임시 경로 이름 반환
     *
     * @return string
     */
    public function getTempPathname()
    {
        return tempnam(sys_get_temp_dir(), 'MediaTemp');
    }

    /**
     * 임시경로에 파일 생성
     *
     * @param string $pathname file pathname
     * @param string $content  file content
     * @return void
     */
    public function createFile($pathname, $content)
    {
        $fp = fopen($pathname, 'wb');
        fwrite($fp, $content);
        fclose($fp);
    }

    /**
     * 임시 파일 삭제
     *
     * @param string $pathname file pathname
     * @return void
     */
    public function remove($pathname)
    {
        unlink($pathname);
    }
}
