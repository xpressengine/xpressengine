<?php
/**
 * HTMLPresenter.php
 *
 * PHP version 7
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Widget\Presenters;

/**
 * Class HTMLPresenter
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class HTMLPresenter implements PresenterInterface
{
    /**
     * The HTML string
     *
     * @var string
     */
    protected $html;

    /**
     * HTMLPresenter constructor.
     *
     * @param string $html html string
     */
    public function __construct($html)
    {
        $this->html = $html;
    }

    /**
     * Get the string contents of the presenter.
     *
     * @return string
     */
    public function render()
    {
        return $this->html;
    }
}
