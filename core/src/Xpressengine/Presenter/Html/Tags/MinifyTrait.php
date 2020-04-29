<?php
/**
 * MinifyTrait
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

use Xpressengine\Presenter\Exceptions\MinifyNotAllowedException;

/**
 * MinifyTrait
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
     *
     * @return $this
     */
    public function min($minified, $useMinified = false)
    {
        if (count($this->files) > 1) {
            throw new MinifyNotAllowedException();
        }
        $this->minified = $minified;
        $this->useMinified = $useMinified;
        return $this;
    }
}
