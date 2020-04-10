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
 * 다국어 key 에서 namespace 와 item 을 분리하는 클래스
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class NamespacedItemResolver
{
    protected $parsed = [];

    protected $laravelNamespace = 'laravel';

    /**
     * Parse a key into namespace and item
     *
     * @param string $key 다국어 키
     * @return array
     */
    public function parseKey($key)
    {
        if (isset($this->parsed[$key])) {
            return $this->parsed[$key];
        }

        if (strpos($key, '::') === false) {
            $parsed = [$this->laravelNamespace, $key];
        } else {
            $parsed = explode('::', $key);
        }

        return $this->parsed[$key] = $parsed;
    }

    /**
     * Get the Laravel's language namespace
     *
     * @return string
     */
    public function getLaravelNamespace()
    {
        return $this->laravelNamespace;
    }
}
