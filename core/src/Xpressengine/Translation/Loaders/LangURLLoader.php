<?php
/**
 * Class Translation
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Translation\Loaders;

use Xpressengine\Translation\LangData;

/**
 * Class LangURLLoader
 *
 * 다국어 센터 처럼 원격의 다국어 파일을 로드하기위한 목적의 클래스
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class LangURLLoader implements LoaderInterface
{
    /**
     * @param string $source 데이터 소스
     * @return LangData
     */
    public function load($source)
    {
        return new LangData();
    }
}
