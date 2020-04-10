<?php
/**
 * Class Support
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
        $this->addElement('xe-widget', 'Block', 'Empty', 'Common', array(
            'id' => 'ID',
            'skin-id' => 'ID',
            'title' => 'Text'
        ));
        // @TODO xewidget제거 @see https://github.com/xpressengine/xpressengine/issues/708
        $this->addElement('xewidget', 'Block', 'Empty', 'Common', array(
            'id' => 'ID',
            'skin-id' => 'ID',
            'title' => 'Text'
        ));
    }
}
