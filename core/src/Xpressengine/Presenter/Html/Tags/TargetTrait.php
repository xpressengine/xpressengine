<?php
/**
 * TargetTrait
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
 * TargetTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
trait TargetTrait
{
    /**
     * @var null|string
     */
    protected $target = null;

    /**
     * set target
     *
     * @param string $target target
     * @return $this
     */
    public function target($target)
    {
        $this->target = $target;
        return $this;
    }
}
