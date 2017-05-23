<?php
namespace App\Skins\Widget;

use Xpressengine\Skin\GenericSkin;

class ContentInfoSkin extends GenericSkin
{
    protected static $id = 'widget/xpressengine@contentInfo/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 콘텐츠 현황 위젯 스킨',
        'description' => 'Xpressengine의 기본 콘텐츠 현황 위젯 스킨입니다'
    ];

    /**
     * @var string
     */
    protected static $path = 'widget.widgets.contentInfo';

    /**
     * @var string
     */
    protected static $viewDir = '';

    protected static $info = [
        'support' => [
            'mobile' => true,
            'desktop' => true
        ]
    ];
}
