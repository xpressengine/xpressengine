<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Theme;

use Xpressengine\Config\ConfigEntity;

/**
 * ThemeEntity는 하나의 테마에 대한 정보를 가지고 있는 클래스이다.
 * XpressEngine에 등록된 테마들의 정보를 ThemeEntity로 생성하여 처리한다.
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ThemeEntity implements ThemeEntityInterface
{

    /**
     * @var string theme id
     */
    protected $id;

    /**
     * @var AbstractTheme class name of theme
     */
    protected $class;

    /**
     * @var AbstractTheme object of theme
     */
    protected $object;

    /**
     * @var ConfigEntity
     */
    protected $config;

    /**
     * ThemeEntity constructor.
     *
     * @param string $id    theme id
     * @param string $class theme class name
     */
    public function __construct($id, $class)
    {
        $this->id = $id;
        $this->class = $class;
    }

    /**
     * get theme id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get class name of theme
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * get theme title
     *
     * @return mixed
     */
    public function getTitle()
    {
        $class = $this->class;
        return $class::getTitle();
    }

    /**
     * get theme's description
     *
     * @return string
     */
    public function getDescription()
    {
        $class = $this->class;
        return $class::getDescription();
    }

    /**
     * get screenshot of theme
     *
     * @return mixed
     */
    public function getScreenshot()
    {
        $class = $this->class;
        return $class::getScreenshot();
    }

    /**
     * get theme setting page url
     *
     * @return null|string
     */
    public function getSettingsURI()
    {
        $class = $this->class;
        return $class::getSettingsURI();
    }

    /**
     * 테마가 desktop 버전을 지원하는지 조사한다.
     *
     * @return bool desktop 버전을 지원할 경우 true
     */
    public function supportDesktop()
    {
        $class = $this->class;
        return $class::supportDesktop();
    }

    /**
     * 테마가 mobile 버전을 지원하는지 조사한다.
     *
     * @return bool mobile 버전을 지원할 경우 true
     */
    public function supportMobile()
    {
        $class = $this->class;
        return $class::supportMobile();
    }

    /**
     * get object of theme
     *
     * @return AbstractTheme
     */
    public function getObject()
    {
        if (isset($this->object) && is_a($this->object, 'Xpressengine\Theme\AbstractTheme')) {
            return $this->object;
        } else {
            $this->object = new $this->class();

            return $this->object;
        }
    }

    /**
     * ThemeEntity에서 제공하지 않는 메소드일 경우 이 entity가 저장하고 있는 theme의 method를 호출한다.
     *
     * @param string $method    method name
     * @param array  $arguments argument list
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->getObject(), $method), $arguments);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options json_encode option
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->getTitle(),
            'class' => $this->class,
            'description' => $this->getDescription(),
            'screenshot' => $this->getScreenshot()
        ];
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return $this->getObject()->render();
    }

    /**
     * return editConfigView
     *
     * @param ConfigEntity $config config data
     *
     * @return \Illuminate\Contracts\View\View|void
     */
    public function renderSetting(ConfigEntity $config = null)
    {
        if ($config === null) {
            $config = $this->setting();
        }
        return $this->getObject()->renderSetting($config);
    }

    /**
     * updateConfig
     *
     * @param array $config pure config data
     *
     * @return array
     */
    public function resolveSetting(array $config)
    {
        return $this->getObject()->resolveSetting($config);
    }

    /**
     * get and set config
     *
     * @param ConfigEntity $config config data
     *
     * @return null
     */
    public function setting(ConfigEntity $config = null)
    {
        return $this->getObject()->setting($config);
    }
}
