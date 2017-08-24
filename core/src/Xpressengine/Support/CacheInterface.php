<?php
/**
 * Cache Interface
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

/**
 * cache 에서 제공되어야 할 기능을 정의 함
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 *
 * @deprecated since beta.22
 */
interface CacheInterface
{
    /**
     * getter
     *
     * @param string $key key name
     * @return mixed
     */
    public function get($key);

    /**
     * setter
     *
     * @param string $key     key name
     * @param mixed  $value   the value
     * @param int    $minutes expire time
     * @return mixed
     */
    public function put($key, $value, $minutes = null);

    /**
     * has
     *
     * @param string $key key name
     * @return bool
     */
    public function has($key);

    /**
     * remove
     *
     * @param string $key key name
     * @return void
     */
    public function forget($key);
}
