<?php
/**
 * LocatableTrait
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
 * LocatableTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
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
     *
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
     *
     * @return $this
     */
    public function prependTo($location)
    {
        $this->location = $location.'.prepend';
        return $this;
    }
}
