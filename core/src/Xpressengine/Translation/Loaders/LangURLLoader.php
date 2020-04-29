<?php
/**
 * Class Translation
 *
 * PHP version 7
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
