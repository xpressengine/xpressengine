<?php
/**
 * Class Translation
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Translation;

/**
 * 다국어 key 에서 namespace 와 item 을 분리하는 클래스
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 */
class NamespacedItemResolver
{
    protected $parsed = array();

    /**
     * @param string $key 다국어 키
     * @return array
     */
    public function parseKey($key)
    {
        if (isset($this->parsed[$key])) {
            return $this->parsed[$key];
        }

        if (strpos($key, '::') === false) {
            $parsed = array('', $key);
        } else {
            $parsed = explode('::', $key);
        }

        return $this->parsed[$key] = $parsed;
    }
}
