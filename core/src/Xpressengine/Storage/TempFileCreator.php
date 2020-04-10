<?php
/**
 * This file is temporary file creator class
 *
 * PHP version 7
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Storage;

/**
 * Class TempFileGenerator
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class TempFileCreator
{
    /**
     * Prefix name for created file name
     *
     * @var string
     */
    protected $prefix;

    /**
     * Constructor
     *
     * @param string $prefix prefix name
     */
    public function __construct($prefix = 'storage')
    {
        $this->prefix = $prefix;
    }

    /**
     * 임시파일 생성
     *
     * @param string $content file content
     * @return TempFile
     */
    public function create($content)
    {
        $pathname = $this->getTempPathname();

        $fp = fopen($pathname, 'wb');
        fwrite($fp, $content);
        fclose($fp);

        return new TempFile($pathname);
    }

    /**
     * 임시 경로 이름 반환
     *
     * @return string
     */
    public function getTempPathname()
    {
        return tempnam(sys_get_temp_dir(), $this->prefix);
    }
}
