<?php
/**
 * Class Translation
 *
 * PHP version 5
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Translation\Loaders;

use Illuminate\Filesystem\Filesystem;
use Xpressengine\Translation\LangData;

/**
 * LangData 클래스에 의해 해석될 수 있는 다국어 데이터 파일 로더
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class LangFileLoader implements LoaderInterface
{
    private $files;

    /**
     * @param Filesystem $files 라라벨 파일 시스템
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * @param string $source 데이터 소스
     * @return LangData
     */
    public function load($source)
    {
        $data = $this->files->getRequire($source);
        $langData = new LangData();
        $langData->setData($data);
        return $langData;
    }
}
