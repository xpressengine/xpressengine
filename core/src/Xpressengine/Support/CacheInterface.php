<?php
/**
 * Cache Interface
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Support;

/**
 * cache 에서 제공되어야 할 기능을 정의 함
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
