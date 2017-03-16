<?php
/**
 *  Class AbstractTheme. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Theme;

use Illuminate\Contracts\Support\Renderable;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Support\MobileSupportTrait;

/**
 * 이 클래스는 Xpressengine에서 테마를 구현할 때 필요한 추상클래스이다. 테마를 Xpressengine에 등록하려면
 * 이 추상 클래스를 상속(extends) 받는 클래스를 작성하여야 한다.
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractTheme implements ComponentInterface, Renderable
{
    use ComponentTrait;
    use MobileSupportTrait;

    /**
     * @var ThemeHandler
     */
    protected static $handler = null;

    /**
     * @var ConfigEntity
     */
    protected $config;

    /**
     * 테마 핸들러를 지정한다.
     *
     * @param ThemeHandler $handler 테마 핸들러
     *
     * @return void
     */
    public static function setHandler(ThemeHandler $handler)
    {
        static::$handler = $handler;
    }

    /**
     * 테마의 이름을 반환한다.
     *
     * @return string
     */
    public static function getTitle()
    {
        return static::getComponentInfo('name');
    }

    /**
     * 테마의 설명을 반환한다.
     *
     * @return string
     */
    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }

    /**
     * 테마의 스크린샷을 반환한다.
     *
     * @return mixed
     */
    public static function getScreenshot()
    {
        if (static::getComponentInfo('screenshot') === null) {
            return null;
        }
        return asset(static::getComponentInfo('screenshot'));
    }

    /**
     * 이 테마가 설정페이지를 제공하는 테마인지 조회한다.
     *
     * @return bool
     */
    public static function hasSetting()
    {
        return true;
    }

    /**
     * 테마 편집 페이지에서 편집할 수 있는 파일의 목록을 반환한다.
     *
     * @return array
     */
    public function getEditFiles()
    {
        return [];
    }

    /**
     * 테마 설정 페이지에 출력할 html 텍스트를 출력한다.
     * 설정폼은 자동으로 생성되며 설정폼 내부에 출력할 html만 반환하면 된다.
     *
     * @param ConfigEntity|null $config 기존에 설정된 설정값
     *
     * @return string
     *
     * @deprecated use renderSetting instead
     */
    public function getSettingView(ConfigEntity $config = null)
    {
        return $this->renderSetting($config);
    }

    /**
     * 테마 설정 페이지에 출력할 html 텍스트를 출력한다.
     * 설정폼은 자동으로 생성되며 설정폼 내부에 출력할 html만 반환하면 된다.
     *
     * @param ConfigEntity|null $config 기존에 설정된 설정값
     *
     * @return string
     */
    public function renderSetting(ConfigEntity $config = null)
    {
        return '';
    }

    /**
     * 테마 설정 페이지에서 입력된 설정값이 저장되기 전 필요한 작업을 처리한다.
     * 사이트관리자가 테마 설정 페이지에서 저장 요청을 할 경우, 테마핸들러가 설정값을 저장하기 전에 이 메소드가 실행된다.
     * 설정값을 보완할 필요가 있을 경우 이 메소드에서 보완하여 다시 반환하면 된다.
     *
     * @param array $config pure config data
     *
     * @return array
     */
    public function resolveSetting(array $config)
    {
        return $config;
    }

    /**
     * 생성된 테마 설정을 삭제하기 전 필요한 작업을 처리한다.
     * 사이트 관리자가 테마 설정 페이지에서 삭제 요청을 할 경우, 테마핸들러가 설정값을 삭제하기 전에 이 메소드가 실행된다.
     *
     * @param ConfigEntity $config
     *
     * @return void
     */
    public function deleteSetting(ConfigEntity $config)
    {
        return;
    }

    /**
     * set or get config info
     *
     * @param ConfigEntity|null $config config data
     *
     * @return ConfigEntity|void
     */
    public function setting(ConfigEntity $config = null)
    {
        if ($config !== null) {
            $this->config = $config;
        }
        return $this->config;
    }
}
