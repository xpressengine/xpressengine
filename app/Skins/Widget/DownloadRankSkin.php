<?php
/**
 * DownloadRankSkin.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Skins\Widget;

use Xpressengine\Skin\GenericSkin;

class DownloadRankSkin extends GenericSkin
{
    protected static $id = 'widget/xpressengine@downloadRank/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 다운로드 위젯 스킨',
        'description' => 'Xpressengine의 기본 다운로드 위젯 스킨입니다'
    ];

    /**
     * @var string
     */
    protected static $path = 'widget.widgets.downloadRank';

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

    public function render()
    {
        $this->data = array_merge($this->data, ['title' => array_get($this->setting(), "@attributes.title")]);

        return parent::render();
    }
}
