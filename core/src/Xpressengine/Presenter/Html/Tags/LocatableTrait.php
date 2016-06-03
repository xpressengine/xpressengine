<?php
/**
 * LocatableTrait
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
 * LocatableTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
trait LocatableTrait
{
    /**
     * @var string
     */
    protected $location = 'body.append';

    /**
     * append to
     *
     * @param string $location location
     * @return $this
     */
    public function appendTo($location)
    {
        $this->location = $location.'.append';
        return $this;
    }

    /**
     * prepend to
     *
     * @param string $location location
     * @return $this
     */
    public function prependTo($location)
    {
        $this->location = $location.'.prepend';
        return $this;
    }
}
