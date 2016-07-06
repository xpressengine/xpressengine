<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Widgets;

use View;
use XeUser;
use Xpressengine\Document\Models\Document;
use Xpressengine\Widget\AbstractWidget;

/**
 * ContentInfo.php
 *
 * PHP version 5
 *
 * @category
 */
class ContentInfo extends AbstractWidget
{

    protected static $id = 'widget/xpressengine@contentInfo';

    /**
     * render
     *
     * @return mixed
     * @internal param array $args to render parameter array
     *
     */
    public function render()
    {
        $viewData = [
            'totalDocument' => Document::count(),
            'totalMember' => XeUser::users()->count(),
        ];
        return View::make('widget.widgets.contentInfo.show', [
            'viewData' => $viewData,
        ]);
    }
}
