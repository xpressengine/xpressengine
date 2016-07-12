<?php
/**
 * TargetTrait
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
     *
     * @return $this
     */
    public function target($target)
    {
        $this->target = $target;
        return $this;
    }
}
