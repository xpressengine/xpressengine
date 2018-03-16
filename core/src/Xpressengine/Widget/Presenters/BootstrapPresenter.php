<?php
/**
 * BootstrapPresenter.php
 *
 * PHP version 5
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Widget\Presenters;

/**
 * Class BootstrapPresenter
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class BootstrapPresenter extends AbstractPresenter
{
    /**
     * The name of presenter
     *
     * @var string
     */
    const NAME = 'Bootstrap';

    /**
     * The number of columns supported by the presenter
     *
     * @var int
     */
    const COLS = 12;

    /**
     * Get HTML wrapper for row contents
     *
     * @param string $content row contents
     * @return string
     */
    protected function getRowWrapper($content)
    {
        return '<div class="row">'.$content.'</div>';
    }

    /**
     * Get HTML wrapper for column contents
     *
     * @param string $content column content
     * @param array  $grid    column grid data
     * @return string
     */
    protected function getColumnWrapper($content, $grid = [])
    {
        $classes = [];
        foreach ($grid as $type => $count) {
            $classes[] = $this->getColumnClass($type, $count);
        }

        return '<div class="'.implode(' ', $classes).'">'.$content.'</div>';
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
        return sprintf('col-%s-%s', $type, $count);
    }
}
