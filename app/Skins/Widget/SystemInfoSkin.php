<?php
namespace App\Skins\Widget;

use Xpressengine\Skin\GenericSkin;

class SystemInfoSkin extends GenericSkin
{
    protected static $id = 'widget/xpressengine@systemInfo/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 시스템 정보 위젯 스킨',
        'description' => 'Xpressengine의 기본 시스템 정보 위젯 스킨입니다'
    ];

    /**
     * @var string
     */
    protected static $path = 'widget.widgets.systemInfo';

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
