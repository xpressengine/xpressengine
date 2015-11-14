<?php
/**
 * AttributeTrait
 *
 * PHP version 5
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Presenter\Html\Tags;

/**
 * AttributeTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
trait AttributeTrait
{
    protected $attributes = [];

    /**
     * 태그에 속성을 지정한다.
     *
     * @param string $name  name
     * @param string $value value
     * @return $this
     */
    public function attr($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }
}
