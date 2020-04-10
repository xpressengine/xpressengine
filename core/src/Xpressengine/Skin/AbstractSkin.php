<?php
/**
 * AbstractSkin class. This file is part of the Xpressengine package.
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

use Illuminate\Contracts\Support\Renderable;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Support\MobileSupportTrait;

/**
 * Xpressengine에서 스킨을 구현할 때 상속받아야 하는 클래스이다.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
        $screenshots = static::getComponentInfo('screenshot');
        if (is_array($screenshots)) {
            return array_shift($screenshots);
        }
        return $screenshots;
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
     * 스킨 설정을 위한 화면에 출력될 html 반환
     *
     * @param array $args 설정 데이터
     *
     * @return mixed
     */
    public function renderSetting(array $args = [])
    {
        return null;
    }

    /**
     * 스킨 설정 페이지에서 입력된 설정값이 저장되기 전 필요한 처리한다.
     * 사이트관리자가 스킨 설정 페이지에서 저장 요청을 할 경우, 스킨핸들러가 설정값을 저장하기 전에 이 메소드가 실행된다.
     * 설정값을 보완할 필요가 있을 경우 이 메소드에서 보완하여 다시 반환하면 된다.
     *
     * @param array $inputs 설정값
     *
     * @return array
     */
    public function resolveSetting(array $inputs = [])
    {
        return $inputs;
    }

    /**
     * set or get config info
     *
     * @param array|null $config config data
     *
     * @return array|void
     */
    public function setting(array $config = null)
    {
        if ($config !== null) {
            $this->config = $config;
        }
        return $this->config;
    }
}
