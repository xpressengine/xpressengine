<?php
/**
 * MinifyTrait
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
 * MinifyTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
trait MinifyTrait
{
    /**
     * @var string
     */
    protected $minified;

    /**
     * @var bool
     */
    protected $useMinified;

    /**
     * min
     *
     * @param string     $minified    minified
     * @param bool|false $useMinified use minified
     * @return $this
     */
    public function min($minified, $useMinified = false)
    {
        $this->minified    = $minified;
        $this->useMinified = $useMinified;
        return $this;
    }
}
