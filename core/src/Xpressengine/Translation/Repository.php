<?php
/**
 * Repository.php
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

namespace Xpressengine\Translation;

/**
 * Interface Repository
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
interface Repository
{
    /**
     * 라인을 얻습니다
     *
     * @param string $namespace 네임스페이스
     * @param string $item      아이템
     * @param string $locale    로케일
     * @return string
     */
    public function getLine($namespace, $item, $locale);

    /**
     * 라인을 추가합니다
     *
     * @param string $namespace 네임스페이스
     * @param string $item      아이템
     * @param string $locale    로케일
     * @param string $value     번역문
     * @param bool   $multiLine 멀티라인 지원 여부
     * @param bool   $force     force update
     * @return void
     */
    public function putLine($namespace, $item, $locale, $value, $multiLine = false, $force = false);

    /**
     * 다국어 데이터를 일괄 등록
     *
     * @param string   $namespace 네임스페이스
     * @param LangData $langData  추가하려는 LangData
     * @param bool     $force     force update
     * @return void
     */
    public function putLangData($namespace, LangData $langData, $force);
}
