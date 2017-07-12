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
 * 에디터에서 사용하는 에디터툴의 추가 속성을 허용하기 위한 필터 추가
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class EditorTool extends HTMLPurifier_HTMLModule
{
    public $name = 'XeEditorTool';

    public $attr_collections = array(
        'Core' => array(
            'xe-tool-id' => 'Text',
            'xe-tool-data' => 'CDATA'
        )
    );
}
