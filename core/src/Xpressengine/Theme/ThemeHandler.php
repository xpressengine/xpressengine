<?php
/**
 * ThemeHandler class. This file is part of the Xpressengine package.
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

use Closure;
use Illuminate\Contracts\View\Factory;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Plugin\PluginRegister;

/**
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ThemeHandler
{

    /**
     * @var ThemeEntity[] 모든 테마 목록
     */
    protected $themeList = [];

    public $configDelimiter = '.';

    protected $cachePath = '';

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
     * @var Factory
     */
    protected $viewFactory;

    /**
     * 생성자
     *
     * @param PluginRegister $register    plugin registry manager
     * @param ConfigManager  $config      config manager
     * @param Factory        $viewFactory view factory
     * @param string         $blankTheme  blanktheme_id
     */
    public function __construct(PluginRegister $register, ConfigManager $config, Factory $viewFactory, $blankTheme)
    {
        $this->register = $register;
        $this->config = $config;
        $this->blankTheme = $blankTheme;
        $this->viewFactory = $viewFactory;
    }

    /**
     * get ViewFactory
     *
     * @return Factory
     */
    public function getViewFactory()
    {
        return $this->viewFactory;
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

    public function setCachePath($path)
    {
        $this->cachePath = $path;
    }

    public function getCachePath($path)
    {
        $cachePath = $this->cachePath.'/'.md5($path);
        return $cachePath;
    }

    public function hasCache($path)
    {
        $cachePath = $this->getCachePath($path);
        return file_exists($cachePath);
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
     * @param string $instanceId 조회할 테마의 id
     *
     * @return ThemeEntity
     */
    public function getTheme($instanceId)
    {
        $strings = explode('.', $instanceId);
        $themeId = $strings[0];

        $registerd = $this->register->get($themeId);

        if ($registerd === null) {
            return null;
        }

        if (isset($this->themeList[$themeId]) === false) {
            $this->themeList[$themeId] = $this->makeEntity($themeId, $registerd);
        }

        $config = $this->getThemeConfig($instanceId);
        $theme = $this->themeList[$themeId];
        $theme->setting($config);

        return $theme;
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
     * 주어진 테마가 저장된 config data를 가지고 있는지 검사한다.
     *
     * @param string $id theme instance id
     *
     * @return bool
     */
    public function hasThemeConfig($id)
    {
        $id = implode($this->configDelimiter, func_get_args());
        $configId = $this->getConfigId($id);
        return $this->config->get($configId) !== null;
    }

    /**
     * 주어진 테마에 저장된 config data를 반환한다.
     *
     * @param string| array $id     theme id
     * @param bool          $create if $create is true and theme config do not exists, create theme config
     *
     * @return ConfigEntity
     */
    public function getThemeConfig($id, $create = false)
    {
        if (is_string($id)) {
            $id = [$id];
        }
        $id = implode($this->configDelimiter, $id);
        $configId = $this->getConfigId($id);

        if ($create && $this->hasThemeConfig($configId) === false) {
            $config = $this->config->set($configId, []);
        } else {
            $config = $this->config->get($configId, true);
        }
        return $config;
    }

    /**
     * 주어진 테마의 config data를 저장한다.
     *
     * @param string       $id         theme id
     * @param string|array $key        config data or config key for setting value
     * @param mixed        $configData config
     *
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
     * 주어진 테마의 config data를 삭제한다.
     *
     * @param string $id    theme id
     *
     * @return void
     */
    public function deleteThemeConfig($id){
        $configId = $this->getConfigId($id);
        $this->config->removeByName($configId);
    }

    /**
     * 주어진 테마에 저장된 모든 config data를 반환한다.
     *
     * @param string $id theme id
     *
     * @return array
     */
    public function getThemeConfigList($id)
    {
        $base = $this->getThemeConfig($id, true);
        $default = $this->getThemeConfig($id.'.0', true);
        $children = $this->config->children($base);

        $configs = [];
        foreach ($children as $config) {
            $id = str_replace($this->getConfigId(''), '', $config->name);
            $configs[$id] = $config;
        }

        return $configs;
    }

    /**
     * config id for given theme
     *
     * @param string $id theme id
     *
     * @return string config id
     */
    public function getConfigId($id)
    {
        return $this->configKey.'.'.$id;
    }

    /**
     * make and return ThemeEntity
     *
     * @param string $id    theme id
     * @param string $class theme class name
     *
     * @return ThemeEntity
     */
    protected function makeEntity($id, $class)
    {
        return new ThemeEntity($id, $class);
    }
}
