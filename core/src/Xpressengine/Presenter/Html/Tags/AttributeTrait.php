<?php
/**
 * AttributeTrait
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

/**
 * AttributeTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait AttributeTrait
{
    protected $attributes = [];

    /**
     * 태그에 속성을 지정한다.
     *
     * @param string $name  name
     * @param string $value value
     *
     * @return $this
     */
    public function attr($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }
}
