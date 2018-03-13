<?php
/**
 * SemanticUIPresenter.php
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
 * Class SemanticUIPresenter
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class SemanticUIPresenter extends AbstractPresenter
{
    /**
     * The name of presenter
     *
     * @var string
     */
    const NAME = 'Semantic UI';

    /**
     * The number of columns supported by the presenter
     *
     * @var int
     */
    const COLS = 16;

    /**
     * Get HTML wrapper for content container.
     *
     * @param string $content content string
     * @return string
     */
    protected function getContainerWrapper($content)
    {
        return '<div class="ui grid">'.$content.'</div>';
    }

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

        return '<div class="'.implode(' ', $classes).' column">'.$content.'</div>';
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
        return sprintf('%s wide $s', $this->int2word($count), $this->type2word($type));
    }

    /**
     * Convert integer number to string
     *
     * @param int $int number
     * @return string
     */
    protected function int2word($int)
    {
        $words = [
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
            'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen'
        ];

        return $words[$int];
    }

    /**
     * Convert type keyword to word for device
     *
     * @param string $type type keyword
     * @return string
     */
    protected function type2word($type)
    {
        $words = ['xs' => 'mobile', 'sm' => 'tablet', 'md' => 'computer', 'lg' => 'large screen'];

        return $words[$type];
    }
}
