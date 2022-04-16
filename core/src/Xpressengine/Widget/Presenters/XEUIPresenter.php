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
     * get row's class
     *
     * @return string
     */
    protected function getRowClass(): string
    {
        return 'xe-row';
    }

    /**
     * Get the css class for given type and count
     *
     * @param string $type  device type
     * @param int    $count span count
     * @return string
     */
    protected function getColumnClass(string $type, int $count): string
    {
        return 'xe-' . parent::getColumnClass($type, $count);
    }
}
