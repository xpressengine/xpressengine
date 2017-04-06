<?php
/**
 * Class Translation
 *
 * PHP version 5
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class LangURLLoader implements LoaderInterface
{
    /**
     * Load the messages by given source
     *
     * @param string $source 데이터 소스
     * @return LangData
     */
    public function load($source)
    {
        return new LangData();
    }
}
