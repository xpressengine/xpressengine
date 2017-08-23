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

namespace Xpressengine\Support\PurifierModules;

use HTMLPurifier_HTMLModule;

/**
 * HTML5 태그 지원
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Html5 extends HTMLPurifier_HTMLModule
{
    public $name = 'HTML5';

    /**
     * setup Add HTML5 tags
     *
     * @see http://htmlpurifier.org/doxygen/html/classHTMLPurifier__Config.html
     * @param HTMLPurifier_Config $config config
     * @return void
     */
    public function setup($config)
    {
        $this->addElement('video', 'Block', 'Flow', 'Common', array(
            'src'      => 'URI',
            'width'    => 'Length',
            'height'   => 'Length',
            'controls' => 'Bool',
            'reload' => 'Bool'
        ));
        $this->addElement('audio', 'Block', 'Flow', 'Common', array(
            'src'      => 'URI',
            'controls' => 'Bool',
        ));
        $this->addElement('source', 'Block', 'Empty', 'Common', array(
            'src' => 'URI',
            'type' => 'Text'
        ));
    }
}
