<?php
/**
 * AbstractWidget class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <develops@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Widget;

use Illuminate\Contracts\Support\Renderable;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Skin\AbstractSkin;

/**
 * 이 클래스는 Xpressengine 에서 Widget 구현할 때 필요한 추상클래스이다.
 * Widget 를 Xpressengine 에 등록하려면
 * 이 추상 클래스를 상속받은 클래스를 작성하여야 한다.
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractWidget implements ComponentInterface, Renderable
{
    use ComponentTrait;

    /**
     * @var array
     */
    public static $ratingWhiteList = ['super', 'manager', 'member', 'guest'];

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
     * @return string
     */
    public function renderSetting(array $args = [])
    {
        return '';
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
