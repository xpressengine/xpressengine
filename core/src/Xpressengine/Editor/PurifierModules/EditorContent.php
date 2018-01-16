<?php
/**
 * Class Support
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Editor\PurifierModules;

use HTMLPurifier_HTMLModule;

/**
 * 에디터와 연계하거나 활용을 위해 콘텐츠에 대해 특정한 속성을 허용
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class EditorContent extends HTMLPurifier_HTMLModule
{
    public $name = 'XeEditorConent';

    public $attr_collections = array(
        'Core' => array(
            //  첨부 파일
            'data-id' => 'Text',
            'xe-file-id' => 'Text',
            // 에디터 툴
            'xe-tool-id' => 'Text',
            'xe-tool-data' => 'CDATA'
        )
    );
}
