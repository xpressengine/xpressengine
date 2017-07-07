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
use Xpressengine\Support\PurifierModules\EditorTool;
use Xpressengine\Support\PurifierModules\Widget;

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
        $app = app();

        $this->config = HTMLPurifier_Config::createDefault();
        $this->config->autoFinalize = false;

        $this->config->loadArray(array_merge(
            $app['config']['purifier.settings.default'],
            [
                'Core.Encoding' => $app['config']['purifier.encoding'],
                'Cache.SerializerPath' => $app['config']['purifier.cachePath'],
                'HTML.AllowedModules' => 'CommonAttributes,Hypertext,Image,List,Nofollow'.
                    ',StyleAttribute,Tables,Text,Legacy,Presentation,Structure,NonXMLCommonAttributes'.
                    ',XMLCommonAttributes',
                'AutoFormat.AutoParagraph' => false,
                'AutoFormat.RemoveEmpty' => false
            ]
        ));
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
     * HTMLModule 로드
     *
     * @see http://htmlpurifier.org/doxygen/html/classHTMLPurifier__HTMLModule.html
     *
     * @param $module string module
     * @return void
     */
    public function allowModule($module)
    {
        $modules = $this->config->get('HTML.AllowedModules');
        $modules[$module] = true;

        $this->config->set('HTML.AllowedModules', $modules);
    }

    /**
     * HTMLModule 제거, 비활성
     *
     * @see http://htmlpurifier.org/doxygen/html/classHTMLPurifier__HTMLModule.html
     *
     * @param $module string module
     * @return void
     */
    public function disallowModule($module)
    {
        $modules = $this->config->get('HTML.AllowedModules');
        unset($modules[$module]);

        $this->config->set('HTML.AllowedModules', $modules);
    }

    /**
     * HTMLPurifier 설정을 추가 변경할 수 없도록 제한
     *
     * @see HTMLPurifier_Config::finalize()
     * @return void
     */
    public function finalize()
    {
        $this->config->finalize();
    }

    /**
     * HTML이 권한이 부여된 자가 작성한 콘텐츠 등 제한을 조금 더 허용하는 수준으로 설정
     *
     * Purifier HTML, CSS 허용 범위가 제한되어 있을 수 있으며, 속성에 대한 값이나 형식, 최대 값 등이 해당될 수 있음.
     * 특정 속성의 사용, 범위 및 값의 제한이 발생하는 경우 이 메소드를 호출하여 제한을 해제할 수 있음.
     *
     * @see http://htmlpurifier.org/live/configdoc/plain.html#HTML.Trusted
     * @see http://htmlpurifier.org/live/configdoc/plain.html#CSS.Trusted
     *
     * @return void
     */
    public function trusted()
    {
        $this->config->set('HTML.Trusted', true);
        $this->config->set('CSS.Trusted', true);
    }

    /**
     * purify
     *
     * @param string $content content
     * @return string
     */
    public function purify($content)
    {
        $htmlDef = $this->config->getHTMLDefinition(true);
        $allowedModules = $this->config->get('HTML.AllowedModules');

        if (in_array('XeEditorTool', $allowedModules)) {
            $htmlDef->manager->addModule(new EditorTool());
        }
        if (in_array('XeWidget', $allowedModules)) {
            $htmlDef->manager->addModule(new Widget());
        }

        $this->finalize();

        $purifier = new HTMLPurifier($this->config);
        return $purifier->purify($content);
    }
}
