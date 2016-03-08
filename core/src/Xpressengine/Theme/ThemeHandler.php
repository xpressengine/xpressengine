<?php
/**
 * ThemeHandler class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Theme;

use Closure;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Plugin\PluginRegister;

/**
 * ThemeHandler는 XpressEngine에 등록된 테마를 관리하는 역할을 합니다. ThemeHandler는 XE에서 `XeTheme` 파사드를 할당받습니다.
 *
 * ## 테마 조회
 *
 * ### 테마 아이디로 테마 조회하기
 *
 * `getTheme` 메소드를 사용하여 테마 아이디로 테마를 조회할 수 있습니다.
 *
 * ```php
 * $id = 'theme/myname@mytheme';
 * $theme = XeTheme::getTheme($id);
 * ```
 *
 * ### 모든 테마 조회하기
 *
 * `getAllTheme` 메소드를 사용하여 모든 테마 목록을 조회할 수 있습니다.
 *
 * ```php
 * $themes = XeTheme::getAllTheme();
 * ```
 *
 * 만약 모바일이나 데스크탑 버전을 지원하는 테마 목록을 조회하려면 `getAllThemeSupportingMobile`,  `getAllThemeSupportingDesktop` 메소드를 사용하십시오.
 *
 * ```php
 * $mobileThemes = XeTheme::getAllThemeSupportingMobile();
 * $desktopThemes = XeTheme::getAllThemeSupportingDesktop();
 * ```
 *
 * ### 관리페이지용 테마 조회하기
 *
 * XpressEngine은 관리페이지에서 사용되는 테마도 교체 가능합니다. 관리페이지용 테마도 ThemeHandler를 사용하여 조회할 수 있습니다.
 *
 * 하나의 관리페이지용 테마를 조회할 때에는 `getTheme`를 동일하게 사용할 수 있습니다.
 *
 * ```php
 * $id = 'settingsTheme/myname@mysettingstheme';
 * $settingsTheme = XeTheme::getTheme($id)
 * ```
 *
 * 모든 관리페이지용 테마 목록을 조회할 때에는 `getAllSettingsTheme`를 사용하십시오.
 *
 * ```php
 * $settingsThemes = XeTheme::getAllSettingsTheme();
 * ```
 *
 * ## 사용할 테마 지정하기
 *
 * XpressEngine에서는 브라우저로부터 요청을 받을 때마다, 응답할 Html을 생성할 때 하나의 테마를 사용합니다.
 * 이때 사용할 테마를 지정해주어야 합니다. (대부분의 경우 XpressEngine 코어에서 자동으로 사용할 테마를 지정해줍니다.)
 *
 * ### 특정 테마를 사용
 *
 * 특정 테마를 응답시 사용하려면 `selectTheme` 메소드를 사용하십시오.
 *
 * ```php
 * $id = 'theme/myname@mytheme';
 * XeTheme::selectTheme($id);
 * ```
 *
 * ### 사이트 기본 테마 사용하기
 *
 * XpressEngine은 아무 테마도 사용할 테마로 지정돼 있지 않을 경우, 기본으로 사용할 테마를 지정해놓고 있습니다.
 * > 사이트관리페이지의 설정 > 사이트 기본설정 메뉴에서 지정할 수 있습니다.
 *
 * 사이트 기본 테마로 지정된 테마를 사용하고 싶을 경우에는 `selectSiteTheme`를 사용하십시오.
 *
 * ```php
 * // 응답시 사이트 기본 테마가 사용됨
 * XeTheme::selectSiteTheme();
 * ```
 *
 * ### 테마 사용 안하기
 *
 * 만약 응답시 아무 테마도 출력되지 않도록 하려면 `selectBlankTheme` 메소드를 사용할 수 있습니다. 테마를 사용하지 않을 경우 순수한 컨텐츠 영역만 출력됩니다.
 *
 * ```php
 * // 응답시 테마 사용 안함.
 * XeTheme::selectBlankTheme();
 * ```
 *
 * ### 지정된 테마 정보 조회
 *
 * 현재 요청에 대한 응답시 사용하기로 지정된 테마를 조회할 수 있습니다. `getSelectedTheme` 메소드를 사용하십시오.
 *
 * ```php
 * $selected = XeTheme::getSelectedTheme();
 * ```
 *
 * ## 테마 설정
 *
 * 테마는 사이트 제목, 로고, 출력할 메뉴와 같이 출력할 때 필요한 설정 정보를 사이트 관리자로부터 입력받을 수 있도록 설정 페이지를 제공합니다.
 * 그리고 설정 페이지로부터 입력된 설정 정보를 ThemeHandler를 통해 데이터베이스에 저장하고, 저장된 정보를 조회할 수 있습니다.
 *
 * > 설정 페이지에 대한 자세한 사항은 '테마 만들기' 매뉴얼을 참고하십시오.
 *
 * ### 테마 설정정보 조회하기
 *
 * `getThemeConfig` 메소드를 사용하면 특정 테마의 설정 정보를 조회할 수 있습니다.
 *
 * ```php
 * $id = 'theme/myname@mytheme';
 * $configs = XeTheme::getThemeConfig($id);
 * ```
 *
 * ### 테마 설정정보 저장하기
 *
 * 반대로 `setThemeConfig` 메소드를 사용하면 특정 테마의 설정 정보를 조회할 수 있습니다.
 *
 * ```php
 * $id = 'theme/myname@mytheme';
 * $configs = [
 * 'site_title' => '내 사이트',
 * 'main_menu' => $menuID,
 * ];
 *
 * XeTheme::setThemeConfig($id, $configs);
 * ```
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ThemeHandler
{

    /**
     * @var ThemeEntity[] 모든 테마 목록
     */
    protected $themeList = [];

    /**
     * @var string Theme config를 조회/저장할 때 Config 저장소에서 사용될 key
     */
    protected $configKey = 'theme.settings';

    /**
     * @var ThemeEntity 현재 요청(Request)에서 사용하기로 지정 돼 있는 테마
     */
    protected $selectedTheme = null;

    /**
     * @var string 현재 요청(Request)에서 사용하기로 지정 돼 있는 테마의 id
     */
    protected $selectedThemeId;

    /**
     * @var PluginRegister Register. 등록된 테마 목록을 저장하고 있다.
     */
    protected $register;

    /**
     * @var ConfigManager Config 저장소. 각 테마의 설정정보를 저장하고 있다.
     */
    protected $config;

    /**
     * @var string blank theme id
     */
    protected $blankTheme;

    /**
     * @var Closure 현재 요청이 모바일 버전인지 조회할 때 사용되는 resolver
     */
    protected $mobileResolver;

    /**
     * 생성자
     *
     * @param PluginRegister $register   plugin registry manager
     * @param ConfigManager  $config     config manager
     * @param string         $blankTheme blanktheme id
     */
    public function __construct(PluginRegister $register, ConfigManager $config, $blankTheme)
    {
        $this->register = $register;
        $this->config = $config;
        $this->blankTheme = $blankTheme;
    }

    /**
     * 현재 요청이 모바일 버전인지 조회할 때 사용되는 resolver를 지정한다.
     *
     * @param Closure $callback resolver
     *
     * @return void
     */
    public function setMobileResolver(Closure $callback)
    {
        $this->mobileResolver = $callback;
    }

    /**
     * 현재 요청이 모바일 버전인지 조회할 때 사용되는 resolver를 조회한다.
     *
     * @return Closure
     */
    public function getMobileResolver()
    {
        return $this->mobileResolver ?: function () {
        };
    }

    /**
     * 현재 Request에서 사용될 테마를 지정한다. 이 메소드를 이용하여 테마를 지정하면, theme middleware에서 지정된 테마를 자동으로 출력한다.
     *
     * @param string $id 지정할 테마의 id
     *
     * @return null
     */
    public function selectTheme($id)
    {
        $this->selectedThemeId = $id;
        $this->selectedTheme = null;
    }

    /**
     * 사이트 기본테마를 사용할 테마로 지정한다.
     * mode가 지정되지 않았을 경우 mobile resolver로부터 mode를 구한다.
     * mode가 지정돼 있을 경우 해당 mode의 테마를 지정한다.
     *
     * @param null $mode mobile or desktop
     *
     * @return void
     */
    public function selectSiteTheme($mode = null)
    {
        if ($mode === null) {
            $resolver = $this->getMobileResolver();
            $mode = $resolver() === true ? 'mobile' : 'desktop';
        }
        $this->selectTheme($this->getSiteThemeId($mode));
    }

    /**
     * 아무 테마도 지정하지 않는다. 내부적으로는 blankTheme를 지정한다.
     *
     * @return void
     */
    public function selectBlankTheme()
    {
        $this->selectTheme($this->blankTheme);
    }

    /**
     * alias for selectBlankTheme()
     *
     * @return void
     */
    public function deselectTheme()
    {
        $this->selectBlankTheme();
    }

    /**
     * 현재 Request에서 사용되는 테마를 반환한다. 반환되는 테마는 일반 테마일 수도 있고, 관리페이지용 테마일수도 있다.
     *
     * @return ThemeEntity
     */
    public function getSelectedTheme()
    {
        if ($this->selectedThemeId === null) {
            return null;
        }
        if ($this->selectedTheme === null) {
            $this->selectedTheme = $this->getTheme($this->selectedThemeId);
        }

        return $this->selectedTheme;
    }

    /**
     * 등록된 테마중 주어진 id를 가진 테마를 반환한다.
     *
     * @param string $id 조회할 테마의 id
     *
     * @return ThemeEntity
     */
    public function getTheme($id)
    {
        $className = $this->register->get($id);

        if ($className === null) {
            return null;
        }

        if (isset($this->themeList[$id]) === false) {
            $this->themeList[$id] = $theme = new ThemeEntity($id, $className);
        }

        return $this->themeList[$id];
    }

    /**
     * 사이트 기본 테마를 지정한다. 사이트 기본 테마 정보는 데이터베이스에 저장 된다.
     *
     * @param string      $id   사이트 기본 테마로 지정할 테마의 아이디, 만약 array일 경우, mobile, desktop용 테마를 동시에 지정한다.
     * @param null|string $mode mobile or desktop, mode가 지정돼 있을 경우 해당 mode만 저장된다.
     *
     * @return void
     */
    public function setSiteTheme($id, $mode = null)
    {
        if (is_array($id)) {
            $configId = 'theme.setting.siteTheme';
        } else {
            if ($mode !== 'mobile') {
                $configId = 'theme.setting.siteTheme.desktop';
            } else {
                $configId = 'theme.setting.siteTheme.mobile';
            }
        }
        $this->config->setVal($configId, $id);
    }

    /**
     * 사이트 기본 테마를 조회한다.
     *
     * @param null|string $mode mobile or desktop
     *
     * @return mixed
     */
    public function getSiteThemeId($mode = null)
    {
        $ids = $this->config->getVal('theme.setting.siteTheme');

        if ($mode === null) {
            return $ids;
        } elseif ($mode === 'desktop') {
            return $ids['desktop'];
        } elseif ($mode === 'mobile') {
            return $ids['mobile'];
        }

        return $ids;
    }

    /**
     * 모든 일반 테마 목록을 반환한다.
     *
     * @return array
     */
    public function getAllTheme()
    {
        $themes = $this->register->get('theme');

        foreach ($themes as $id => $class) {
            $themes[$id] = $this->getTheme($id);
        }

        return $themes;
    }

    /**
     * getAllThemeSupportingMobile
     *
     * @return array
     */
    public function getAllThemeSupportingMobile()
    {
        $themes = $this->getAllTheme();
        return array_where(
            $themes,
            function ($id, $entity) {
                /** @var ThemeEntity $entity */
                return $entity->supportMobile();
            }
        );
    }

    /**
     * getAllThemeSupportingDesktop
     *
     * @return array
     */
    public function getAllThemeSupportingDesktop()
    {
        $themes = $this->getAllTheme();
        return array_where(
            $themes,
            function ($id, $entity) {
                /** @var ThemeEntity $entity */
                return $entity->supportDesktop();
            }
        );
    }

    /**
     * 모든 관리페이지 테마 목록을 반환한다.
     *
     * @return array
     */
    public function getAllSettingsTheme()
    {
        $themes = $this->register->get('settingsTheme');
        foreach ($themes as $id => $class) {
            $themes[$id] = $this->getTheme($id);
        }
        return $themes;
    }

    /**
     * getThemeConfig
     *
     * @param string $id theme id
     *
     * @return ConfigEntity
     */
    public function getThemeConfig($id)
    {
        $configId = $this->getConfigId($id);
        return $this->config->get($configId);
    }

    /**
     * setThemeConfig
     *
     * @param string       $id         theme id
     * @param string|array $key        config data or, config key for setting value
     * @param mixed        $configData config
     * @return void
     */
    public function setThemeConfig($id, $key, $configData = null)
    {
        if ($configData === null) {
            $configData = $key;
            $key = null;
        } else {
            $id = $id.'.'.$key;
        }

        $configId = $this->getConfigId($id);

        if ($key === null) {
            $this->config->set($configId, $configData);
        } else {
            $this->config->setVal($configId, $configData);
        }
    }

    /**
     * config id for given theme
     *
     * @param string $id theme id
     *
     * @return string config id
     */
    private function getConfigId($id)
    {
        return $this->configKey.'.'.$id;
    }
}
