<?php
/**
 * LocatableTrait.php
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
 * trait LocatableTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait LocatableTrait
{
    /**
     * @var array
     */
    protected $locations = [];

    /**
     * Append to
     *
     * @param string $location location prefix
     * @return $this
     */
    public function appendTo($location)
    {
        return $this->location($location.'.append');
    }

    /**
     * Prepend to
     *
     * @param string $location location prefix
     * @return $this
     */
    public function prependTo($location)
    {
        return $this->location($location.'.prepend');
    }

    /**
     * Add location for current object.
     *
     * @param string $location location
     * @return $this
     */
    public function location($location)
    {
        $this->locations[] = $location;
        $this->locations = array_filter(array_unique($this->locations));

        return $this;
    }

    /**
     * Get registered locations for current object.
     *
     * @return array
     */
    public function getLocations()
    {
        return !empty($this->locations) ? $this->locations : ['body.append'];
    }
}
