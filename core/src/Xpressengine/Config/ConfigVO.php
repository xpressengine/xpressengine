<?php
/**
 * Value object class
 *
 * PHP version 5
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Config;

use Closure;
use Illuminate\Support\Fluent;

/**
 * 특정 대상이 가지는 여러 값을 가지는 entity 클래스
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ConfigVO extends Fluent
{
    /**
     * except closure values
     *
     * @return array
     */
    public function scalar()
    {
        $scalars = [];
        foreach ($this->attributes as $key => $value) {
            if ($value instanceof Closure === false) {
                $scalars[$key] = $value;
            }
        }

        return $scalars;
    }

    /**
     * for "json_encode"
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->scalar();
    }
}
