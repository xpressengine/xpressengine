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
use Xpressengine\Editor\PurifierModules\EditorContent;
use Xpressengine\Support\PurifierModules;
use Xpressengine\Widget\PurifierModules\Widget;

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
    public $modules = [];

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
                'AutoFormat.RemoveEmpty' => false,
                'Attr.EnableID' => true
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
     * @param string $module module
     * @return boid
     */
    public function allowModule($module)
    {
        if (class_exists($module)) {
            $this->addHtmlDefinition($module);
        } else {
            $modules = $this->config->get('HTML.AllowedModules');
            $modules[$module] = true;

            $this->config->set('HTML.AllowedModules', $modules);
        }
    }

    /**
     * HTMLModule 제거, 비활성
     *
     * @see http://htmlpurifier.org/doxygen/html/classHTMLPurifier__HTMLModule.html
     * @param string $module module
     * @return void
     */
    public function disallowModule($module)
    {
        if (class_exists($module)) {
            $this->removeHtmlDefinition($module);
        } else {
            $modules = $this->config->get('HTML.AllowedModules');
            unset($modules[$module]);
            $this->config->set('HTML.AllowedModules', $modules);
        }
    }

    /**
     * HTMLPurifier HTMLModule 추가 로드
     * `\HTMLPurifier_HTMLModule`로 정의된 추가 확장
     *
     * @see http://htmlpurifier.org/doxygen/html/classHTMLPurifier__HTMLModule.html
     *
     * @param string $module module class
     * @return void
     */
    private function addHtmlDefinition($module)
    {
        $this->modules[] = $module;
        $this->modules = array_unique($this->modules);
    }

    /**
     * HTMLPurifier HTMLModule 제거
     *
     * @see http://htmlpurifier.org/doxygen/html/classHTMLPurifier__HTMLModule.html
     *
     * @param string $module module
     * @return void
     */
    private function removeHtmlDefinition($module)
    {
        $key = array_search($module, $this->modules);
        if ($key !== false) {
            unset($this->modules[$key]);
        }
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

        foreach ($this->modules as $module) {
            /* @deprecated 기존 코드처리를 위한 임시 코드 */
            if (!class_exists($module)) {
                $allowedModules = $this->config->get('HTML.AllowedModules');

                if (array_key_exists('XeEditorContent', $allowedModules)) {
                    $htmlDef->manager->addModule(new EditorContent());
                }
                if (array_key_exists('XeEditorTool', $allowedModules)) {
                    $htmlDef->manager->addModule(new EditorContent());
                }
                if (array_key_exists('HTML5', $allowedModules)) {
                    $htmlDef->manager->addModule(new PurifierModules\Html5());
                }
                if (array_key_exists('XeWidget', $allowedModules)) {
                    $htmlDef->manager->addModule(new Widget());
                }

                continue;
            }
            /* @deprecated end */

            $htmlDef->manager->addModule(new $module());
        }

        $this->finalize();

        $purifier = new HTMLPurifier($this->config);
        return $purifier->purify($content);
    }
}
