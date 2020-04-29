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

namespace Xpressengine\Support;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Container\Container;

/**
 * HTML 을 전달하는 에디터를 사용할 경우 사이트에서 사용하는 Purifier 와 다른
 * 규칙을 사용해야할 필요가 있어 이를 위해 헬퍼 제공
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
     * @var Container
     */
    protected $app;

    /**
     * Purifier constructor
     *
     * @param Container $app container instance
     */
    public function __construct(Container $app = null)
    {
        $this->app = $app ?: $this->getContainer();

        $this->config = HTMLPurifier_Config::createDefault();
        $this->config->autoFinalize = false;

        $this->config->loadArray(array_merge(
            $this->app['config']['purifier.settings.default'],
            [
                'Cache.SerializerPath' => $this->app['config']['purifier.cachePath']
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
     * @return void
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
        if (!$this->app['request']->user()->isAdmin()) {
            $this->config->set('HTML.Nofollow', true);
        }

        $htmlDef = $this->config->getHTMLDefinition(true);

        foreach ($this->modules as $module) {
            $htmlDef->manager->addModule(new $module());
        }

        $this->finalize();

        $purifier = new HTMLPurifier($this->config);
        return $purifier->purify($content);
    }

    /**
     * Return container instance
     *
     * @return Container
     */
    protected function getContainer()
    {
        return Container::getInstance();
    }
}
