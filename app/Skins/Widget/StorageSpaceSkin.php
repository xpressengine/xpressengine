<?php
namespace App\Skins\Widget;

use Xpressengine\Skin\GenericSkin;

class StorageSpaceSkin extends GenericSkin
{
    protected static $id = 'widget/xpressengine@storageSpace/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 스토리지 위젯 스킨',
        'description' => 'Xpressengine의 기본 스토리지 위젯 스킨입니다'
    ];

    /**
     * @var string
     */
    protected static $path = 'widget.widgets.storageSpace';

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
