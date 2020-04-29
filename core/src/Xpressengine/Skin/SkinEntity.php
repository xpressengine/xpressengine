<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Skin;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;

/**
 * SkinEntity는 하나의 스킨에 대한 정보를 가지고 있는 클래스이다.
 * SkinaHandler는 등록된 스킨들의 정보를 처리할 때, SkinEntity로 생성하여 사용한다.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @method AbstractSkin setData($data)
 * @method AbstractSkin setView($view)
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SkinEntity implements Arrayable, Jsonable
{

    /**
     * @var string skin id
     */
    protected $id;

    /**
     * @var AbstractSkin class name of skin
     */
    protected $class;

    /**
     * @var AbstractSkin object of skin
     */
    protected $object;

    /**
     * @var array
     */
    private $config;

    /**
     * @var SkinEntity $defaultSkin
     */
    protected $defaultSkin;

    /**
     * SkinEntity constructor.
     *
     * @param string $id     skin id
     * @param string $class  skin class name
     * @param array  $config skin config data
     */
    public function __construct($id, $class, array $config = null)
    {
        $this->id = $id;
        $this->class = $class;
        $this->config = $config;
    }

    /**
     * get skin id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get class name of skin
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * get skin title
     *
     * @return mixed
     */
    public function getTitle()
    {
        $class = $this->class;
        return $class::getTitle();
    }

    /**
     * get skin's description
     *
     * @return string
     */
    public function getDescription()
    {
        $class = $this->class;
        return $class::getDescription();
    }

    /**
     * get screenshot of skin
     *
     * @return mixed
     */
    public function getScreenshot()
    {
        $class = $this->class;
        return $class::getScreenshot();
    }

    /**
     * get skin setting view
     *
     * @param array $args skin config
     *
     * @return string|Renderable
     */
    public function renderSetting(array $args = [])
    {
        return $this->getObject()->renderSetting($args);
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
     * @param array $config config data
     *
     * @return null
     */
    public function setting(array $config = null)
    {
        return $this->getObject()->setting($config);
    }

    /**
     * 스킨이 desktop 버전을 지원하는지 조사한다.
     *
     * @return bool desktop 버전을 지원할 경우 true
     */
    public function supportDesktop()
    {
        $class = $this->class;
        return $class::supportDesktop();
    }

    /**
     * 스킨이 desktop 버전만을 지원하는지 조사한다.
     *
     * @return bool desktop 버전만을 지원할 경우 true
     */
    public function supportDesktopOnly()
    {
        $class = $this->class;
        return $class::supportDesktopOnly();
    }

    /**
     * 스킨이 mobile 버전을 지원하는지 조사한다.
     *
     * @return bool mobile 버전을 지원할 경우 true
     */
    public function supportMobile()
    {
        $class = $this->class;
        return $class::supportMobile();
    }

    /**
     * 스킨이 mobile 버전만을 지원하는지 조사한다.
     *
     * @return bool mobile 버전만을 지원할 경우 true
     */
    public function supportMobileOnly()
    {
        $class = $this->class;
        return $class::supportMobileOnly();
    }

    /**
     * get object of skin
     *
     * @return AbstractSkin
     */
    public function getObject()
    {
        if (isset($this->object) && is_a($this->object, 'Xpressengine\Skin\AbstractSkin')) {
            return $this->object;
        } else {
            $this->object = new $this->class($this->config);

            if ($this->defaultSkin) {
                $this->object->setDefaultSkin($this->defaultSkin->getObject());
            }

            return $this->object;
        }
    }

    /**
     * SkinEntity에서 제공하지 않는 메소드일 경우 이 entity가 저장하고 있는 skin의 method를 호출한다.
     *
     * @param string $method    method name
     * @param array  $arguments argument list
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->getObject($this->config), $method), $arguments);
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
     * 기본 스킨을 주입
     *
     * @param SkinEntity $defaultSkin default skin entity
     *
     * @return void
     */
    public function setDefaultSkin(SkinEntity $defaultSkin)
    {
        $this->defaultSkin = $defaultSkin;
    }
}
