<?php
/**
 * TargetTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html\Tags;

/**
 * TargetTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
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
