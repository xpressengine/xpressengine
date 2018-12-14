<?php
/**
 * ContentInfo.php
 *
 * PHP version 7
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Widgets;

use View;
use XeUser;
use Xpressengine\Document\Models\Document;
use Xpressengine\Widget\AbstractWidget;

/**
 * Class ContentInfo
 *
 * @category    Widgets
 * @package     App\Widgets
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ContentInfo extends AbstractWidget
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'widget/xpressengine@contentInfo';

    /**
     * Returns the title of the widget.
     *
     * @return string
     */
    public static function getTitle()
    {
        return '콘텐츠 현황 위젯';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $viewData = [
            'totalDocument' => Document::count(),
            'totalUser' => XeUser::users()->count(),
        ];

        return $this->renderSkin([
            'viewData' => $viewData,
        ]);
    }
}
