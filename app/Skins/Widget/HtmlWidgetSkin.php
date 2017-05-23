<?php
namespace App\Skins\Widget;

use Xpressengine\Skin\GenericSkin;

class HtmlWidgetSkin extends GenericSkin
{
    protected static $id = 'widget/xpressengine@html/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 HTML 직접 입력 위젯 스킨',
        'description' => 'Xpressengine의 기본 HTML 직접 입력 위젯 스킨입니다'
    ];

    /**
     * @var string
     */
    protected static $path = 'widget.widgets.htmlwidget';

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
