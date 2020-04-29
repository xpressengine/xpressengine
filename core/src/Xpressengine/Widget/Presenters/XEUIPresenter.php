<?php
/**
 * XEUIPresenter.php
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
 * class XEUIPresenter
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class XEUIPresenter extends BootstrapPresenter
{
    /**
     * The name of presenter
     *
     * @var string
     */
    const NAME = 'XE UI';

    /**
     * Get HTML wrapper for row contents
     *
     * @param string $content row contents
     * @return string
     */
    protected function getRowWrapper($content)
    {
        return '<div class="xe-row">'.$content.'</div>';
    }

    /**
     * Get the css class for given type and count
     *
     * @param string $type  device type
     * @param int    $count span count
     * @return string
     */
    protected function getColumnClass($type, $count)
    {
        return 'xe-' . parent::getColumnClass($type, $count);
    }
}
