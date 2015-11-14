<?php
/**
 * AbstractSkin class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Skin;

use Illuminate\Contracts\Support\Renderable;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Support\MobileSupportTrait;

/**
 * Xpressengine에서 스킨을 구현할 때 상속받아야 하는 클래스이다.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class AbstractSkin implements ComponentInterface, Renderable
{
    use ComponentTrait;
    use MobileSupportTrait;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array|null
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $view;

    /**
     * 스킨이 XE에 등록된 다음 실행되어야 하는 코드가 있을 경우 여기에 작성한다.
     *
     * @return void
     */
    public static function boot()
    {
        return;
    }

    /**
     * get settings uri
     *
     * @return string|null
     */
    public static function getSettingsURI()
    {
        return null;
    }

    /**
     * AbstractSkin constructor.
     *
     * @param array $config configuration data
     */
    public function __construct($config = null)
    {
        $this->config = $config;
    }

    /**
     * get title of skin
     *
     * @return string
     */
    public static function getTitle()
    {
        return static::getComponentInfo('name');
    }

    /**
     * get description of skin
     *
     * @return string
     */
    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }

    /**
     * get screenshot url of skin
     *
     * @return string
     */
    public static function getScreenshot()
    {
        return static::getComponentInfo('screenshot');
    }

    /**
     * 스킨을 출력할 때 필요한 데이터를 지정한다. 이 메소드는 chaining 방식으로 호출 가능하도록 $this를 반환한다.
     *
     * @param mixed $data 지정할 데이터
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 스킨을 출력할 때 필요한 view id를 지정한다. 이 스킨을 사용하는 곳에서는 스킨 출력시 어떤 view를 출력할지 지정해야 한다.
     * 이 메소드는 chaining 방식으로 호출 가능하도록 $this를 반환한다.
     *
     * @param string $view 스킨 출력(render)시 사용할 view 지정
     *
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * 만약 view 이름과 동일한 메소드명이 존재하면 그 메소드를 호출한다.
     *
     * @return Renderable|string
     */
    public function render()
    {
        $view = $this->view;
        $view = ucwords(str_replace(['-', '_', '.'], ' ', $view));
        $method = lcfirst(str_replace(' ', '', $view));

        return $this->$method();
    }

    /**
     * get skin's config data
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * 스킨 설정을 위한 화면에 출력될 html 반환
     *
     * @param array $config skin config
     *
     * @return string|Renderable
     */
    public static function getSettingView($config = [])
    {
        return '';
    }
}
