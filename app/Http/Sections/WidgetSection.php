<?php
/**
 * WidgetSection.php
 *
 * PHP version 7
 *
 * @category    Sections
 * @package     App\Http\Sections
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Sections;

use View;
use Xpressengine\Widget\WidgetHandler;

/**
 * Class WidgetSection
 *
 * @category    Sections
 * @package     App\Http\Sections
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class WidgetSection extends Section
{
    /**
     * The target id
     *
     * @var string
     */
    protected $targetId;

    /**
     * WidgetSection constructor.
     *
     * @param string $targetId target id
     */
    public function __construct($targetId)
    {
        $this->targetId = $targetId;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        /**
         * @var WidgetHandler @widgetHandler
         */
        $widgetHandler = app('xe.widget');
        $widgets = $widgetHandler->getAll();

        return View::make('widget.list', [
            'widgets' => $widgets,
            'targetId' => $this->targetId
        ]);
    }
}
