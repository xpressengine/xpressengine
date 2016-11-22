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

namespace Xpressengine\Support;

use HTMLPurifier;
use HTMLPurifier_Config;

/**
 * HTML 을 전달하는 에디터를 사용할 경우 사이트에서 사용하는 Purifier 와 다른
 * 규칙을 사용해야할 필요가 있어 이를 위해 헬퍼 제공
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Purifier
{
    /**
     * @var HTMLPurifier_Config
     */
    protected $config;

    /**
     * @var array
     */
    public $default = [
    ];

    /**
     * Purifier constructor
     */
    public function __construct()
    {
        $this->config = HTMLPurifier_Config::createDefault();
        $this->config->loadArray([
            'Core.Encoding' => 'UTF-8',
            'Cache.SerializerPath' => storage_path('framework/htmlpurifier/support'),
            'HTML.Doctype'             => 'XHTML 1.0 Strict',
            'HTML.Allowed'             => 'div,b,strong,i,em,a[href|title],ul,ol,li,p[style]' .
                ',br,span[style|class|data-download-link|contenteditable]' .
                ',img[width|height|alt|src],table[summary],tbody,th[abbr],tr,td[abbr]',
            'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family' .
                ',text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph' => true,
            'AutoFormat.RemoveEmpty'   => true
        ]);

        $def = $this->config->getHTMLDefinition(true);
        $def->addAttribute('span', 'data-download-link', 'Text');
        $def->addAttribute('span', 'contenteditable', 'Text');
    }

    /**
     * get purifier config
     *
     * @return HTMLPurifier_Config
     */
    public function get()
    {
        return $this->config;
    }

    /**
     * set purifier config
     *
     * @param HTMLPurifier_Config $config config
     * @return $this
     */
    public function set(HTMLPurifier_Config $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * purify
     *
     * @param string $content content
     * @return string
     */
    public function purify($content)
    {
        $purifier = new HTMLPurifier($this->config);
        return $purifier->purify($content);
    }
}
