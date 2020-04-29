<?php
/**
 * SortTrait
 *
 * PHP version 7
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html\Tags;

use Xpressengine\Support\Sorter;

/**
 * SortTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait SortTrait
{
    /**
     * @var array
     */
    protected $befores = [];

    /**
     * @var array
     */
    protected $afters = [];


    /**
     * @var array
     */
    protected static $sorted = [];

    /**
     * before
     *
     * @param string $befores befores
     * @return $this
     */
    public function before($befores)
    {
        $befores = array_map(
            function ($before) {
                return $this->resolveKey($before);
            },
            (array) $befores
        );

        $this->befores = array_merge($this->befores, (array) $befores);
        return $this;
    }

    /**
     * after
     *
     * @param string $afters afters
     * @return $this
     */
    public function after($afters)
    {
        $afters = array_map(
            function ($after) {
                return $this->resolveKey($after);
            },
            (array) $afters
        );

        $this->afters = array_merge($this->afters, (array) $afters);
        return $this;
    }

    /**
     * Resolving by given key.
     *
     * @param string $key key string
     * @return string
     */
    abstract protected function resolveKey($key);

    /**
     * Do sort.
     *
     * @param string|array $items items
     * @param string       $group sort group
     * @return void
     */
    protected function sort($items, $group = '*')
    {
        $items = is_array($items) ? $items : [$items];

        $list = array_unique(array_merge(static::$sorted[$group] ?? [], $this->befores, $this->afters));

        if (!empty($this->befores)) {
            $list = array_values(array_diff($list, $items));
            $indexes = array_keys(array_intersect($list, $this->befores));
            $key = array_pop($indexes);
            array_splice($list, $key+1, 0, $items);
        } else {
            $list = array_merge($list, $items);
        }

        if (!empty($this->afters)) {
            $list = array_values(array_diff($list, $this->afters));
            $indexes = array_keys(array_intersect($list, $items));
            $key = array_pop($indexes);
            array_splice($list, $key+1, 0, $this->afters);
        }

        static::$sorted[$group] = array_values(array_unique($list));
    }

    /**
     * Get sorted list.
     *
     * @param string $group sort group
     * @return array
     */
    public static function getSorted($group = '*')
    {
        return static::$sorted[$group] ?? [];
    }
}
