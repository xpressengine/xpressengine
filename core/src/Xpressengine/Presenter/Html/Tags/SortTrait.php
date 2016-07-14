<?php
/**
 * SortTrait
 *
 * PHP version 5
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html\Tags;

use Xpressengine\Support\Sorter;

/**
 * SortTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 */
trait SortTrait
{

    /**
     * @var Sorter 우선순위 정렬을 위한 sorter
     */
    protected static $sorter;

    /**
     * @var array
     */
    protected $befores = [];

    /**
     * @var array
     */
    protected $afters = [];

    /**
     * before
     *
     * @param string $befores befores
     *
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
     *
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
}
