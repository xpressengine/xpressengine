<?php
/**
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
     * 위젯의 이름을 반환한다.
     *
     * @return string
     */
    public static function getTitle()
    {
        return '콘텐츠 현황 위젯';
    }

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

        return $this->renderSkin(
            [
                'viewData' => $viewData,
            ]
        );
    }
}
