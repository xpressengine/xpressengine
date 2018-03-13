<?php
/**
 * HTMLPresenter.php
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
 * Class HTMLPresenter
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
