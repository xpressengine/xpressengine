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

namespace Xpressengine\Translation;

/**
 * 중첩 구조의 다국어 데이터 파일을 다루는 클래스
 * .(dot) 기반의 item의 line으로 변형할 수 있게 도와주는 포매터 기능 제공
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class LangData
{
    private $data = [];

    /**
     * @param array $data 다국어 데이터
     * @return void
     */
    public function setData($data)
    {
        foreach (array_dot($data) as $key => $value) {
            $arrKey = explode('.', $key);
            $locale = array_pop($arrKey);
            $item = implode('.', $arrKey);
            $this->setLine($item, $locale, $value);
        }
    }

    /**
     * @param string $item   아이템
     * @param string $locale 로케일
     * @param string $value  번역문
     * @return void
     */
    public function setLine($item, $locale, $value)
    {
        $this->data[$item][$locale] = $value;
    }

    /**
     * @param \Closure $closure 반복자
     * @return void
     */
    public function each(\Closure $closure)
    {
        foreach ($this->data as $item => $locales) {
            foreach ($locales as $locale => $value) {
                $closure($item, $locale, $value);
            }
        }
    }
}
