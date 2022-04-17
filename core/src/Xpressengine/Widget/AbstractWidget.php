<?php
/**
 * AbstractWidget class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <develops@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Widget;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Plugin\SupportInfoTrait;
use Xpressengine\Skin\AbstractSkin;
use Xpressengine\User\Rating;

/**
 * 이 클래스는 Xpressengine 에서 Widget 구현할 때 필요한 추상클래스이다.
 * Widget 를 Xpressengine 에 등록하려면
 * 이 추상 클래스를 상속받은 클래스를 작성하여야 한다.
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class AbstractWidget implements ComponentInterface, Renderable
{
    use ComponentTrait, SupportInfoTrait;

    /**
     * @var array
     */
    public static $ratingWhiteList = [Rating::SUPER, Rating::MANAGER, Rating::USER, Rating::GUEST];

    protected $config;

    protected $data;

    /**
     * AbstractWidget constructor.
     *
     * @param array|null $config widget config data
     */
    public function __construct($config = null)
    {
        $this->config = $config;
        $this->init();
    }

    /**
     * 위젯을 생성할 때 필요한 초기화 작업을 여기에 작성하세요.
     *
     * @return void
     */
    protected function init()
    {
        if ($this->config !== null) {
            if (method_exists($this, 'convertDataMediaLibraryImage') == true) {
                $this->convertDataMediaLibraryImage('setting', $this->config);
            }

            if ($skinId = array_get($this->config, '@attributes.skin-id')) {
                if ($skin = app('xe.skin')->get($skinId, $this->config)) {
                    if (method_exists($skin->getClass(), 'convertDataMediaLibraryImage') == true) {
                        $skin->getClass()::convertDataMediaLibraryImage('setting', $this->config);
                    }
                }
            }
        }
    }

    /**
     * 위젯의 이름을 반환한다.
     *
     * @return string
     */
    public static function getTitle()
    {
        return static::getComponentInfo('name');
    }

    /**
     * 위젯의 설명을 반환한다.
     *
     * @return string
     */
    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }

    /**
     * 지정된 스킨을 통해 widget을 출력한다.
     *
     * @param array $data 스킨에 전달할 데이터
     *
     * @return string
     */
    public function renderSkin(array $data)
    {
        $skinId = array_get($this->config, '@attributes.skin-id');

        /** @var AbstractSkin $skin */
        $skin = app('xe.skin')->get($skinId, $this->config);

        return $skin->setData($data)->setView('widget')->render();
    }

    /**
     * 위젯 설정 페이지에 출력할 폼을 출력한다.
     *
     * @param array $args 설정값
     *
     * @throws Exception
     *
     * @return string
     */
    public function renderSetting(array $args = [])
    {
        if ($args === null) {
            $args = $this->setting();
        }

        try{
            $view = $this->info('setting');
        }
        catch (\ErrorException  $exception) {
            $view = null;
        }

        if (is_null($view)) {
            return '';
        } elseif (is_string($view)) {
            return view($this->view($view), compact('config', '_skin'));
        } elseif (is_array($view)) {
            return $this->makeConfigView($view, $args);
        }
    }

    /**
     * view 반환한다.
     *
     * @param string $view view name
     *
     * @return string
     */
    protected function view($view)
    {
        return str_replace('/', '.', static::$path) . '.views.' . $view;
    }

    /**
     * `info.php`에 적혀있는 settings 값을 바탕으로 폼을 생성하고 반환.
     *
     * @param array $info setting form info
     * @param array $data old config data
     * @return string
     * @throws Exception
     */
    protected function makeConfigView(array $info, array $data)
    {
        $this->convertInfoMediaLibraryImage($info, $data);
        return uio('form', ['type'=> 'fieldset', 'class' => $this->getId(), 'inputs' => $info, 'value' => $data]);
    }

    /**
     * 사용자가 위젯 설정 페이지에 입력한 설정값을 저장하기 전에 전처리 한다.
     *
     * @param array $inputs 사용자가 입력한 설정값
     *
     * @return array
     */
    public function resolveSetting(array $inputs = [])
    {
        return $inputs;
    }

    /**
     * 현재 위젯에 지정된 설정값을 조회하거나, 저장한다.
     *
     * @param array|null $config 저장할 설정값, null일 경우 이 메소드는 저장된 설정값을 반환한다.
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
