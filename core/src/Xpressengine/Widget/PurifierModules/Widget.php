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

namespace Xpressengine\Widget\PurifierModules;

use HTMLPurifier_HTMLModule;

/**
 * HTML에서 위젯 코드를 유지하기위한 허용 필터
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Widget extends HTMLPurifier_HTMLModule
{
    public $name = 'XeWidget';

    /**
     * setup HTMLModule
     * @see http://htmlpurifier.org/doxygen/html/classHTMLPurifier__Config.html
     * @param \HTMLPurifier_Config $config config
     * @return void
     */
    public function setup($config)
    {
        $this->addElement('xewidget', 'Block', 'Empty', 'Common', array(
            'id' => 'ID',
            'skin-id' => 'ID',
            'title' => 'Text'
        ));
    }
}
