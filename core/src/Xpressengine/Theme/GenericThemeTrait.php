<?php
/**
 *  This file is part of the Xpressengine package.
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

use Xpressengine\Config\ConfigEntity;

/**
 * 이 Trait은 path기반의 테마(GenericTheme)에서 필요한 구현의 모음이다.
 * GenericTheme와 CompactThemeEntity에서 사용한다.
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
trait GenericThemeTrait
{
    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $config = $this->setting();

        $this->registerViewNamespace();

        $view = $this->viewname('view', 'theme');
        return static::$handler->getViewFactory()->make($view, compact('config'));
    }

    /**
     * 각 테마는 편집 페이지에서 편집할 수 있는 템플릿파일(blade)이나 css 파일 목록을 지정한다.
     * 이 메소드는 그 파일 목록을 조회한다.
     *
     * @return array
     */
    public function getEditFiles()
    {
        $path = base_path($this->getPath().DIRECTORY_SEPARATOR.'views');
        $editable = $this->info('editable');

        $files = [];
        foreach ($editable as $type => $list) {
            $files[$type] = [];
            foreach ($list as $file) {
                $files[$type][$file] = base_path($path.DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR.$file);
            }
        }
        return $files;
    }

    /**
     * return editConfigView
     *
     * @param ConfigEntity $config
     *
     * @return \Illuminate\Contracts\View\View|void
     */
    public function getSettingView(ConfigEntity $config = null)
    {
        if ($config === null) {
            $config = $this->setting();
        }
        $view = array_get($this->info, 'config', 'config');

        $this->registerViewNamespace();

        if (is_string($view)) {
            return static::$handler->getViewFactory()->make($this->viewname($view, 'config'), compact('config'));
        } elseif (is_array($view)) {
            return $this->makeConfigView($view, $config);
        }
    }

    /**
     * updateConfig
     *
     * @param array $config
     *
     * @return array
     */
    public function updateSetting(array $config)
    {
        return $config;
    }


    /**
     * makeConfigView
     *
     * @param array        $info
     * @param ConfigEntity $old
     *
     * @return string
     */
    protected function makeConfigView(array $info, ConfigEntity $old)
    {
        return uio('form', ['class' => $this->getId(), 'inputs' => $info, 'values' => $old]);
    }


    /**
     * get and set config
     *
     * @param ConfigEntity $config
     *
     * @return ConfigEntity
     */
    public function setting(ConfigEntity $config = null)
    {
        if ($config !== null) {
            $this->config = $config;
        }
        return $this->config;
    }

    /**
     * view
     *
     * @param        $name
     * @param string $default
     *
     * @return string
     */
    protected function viewname($name, $default = '')
    {
        return static::$viewNamespace.'::'.array_get($this->info(), $name, $default);
    }

    /**
     * registerViewNamespace
     *
     * @return void
     */
    protected function registerViewNamespace()
    {
        // register '_theme::' view namespace
        static::$handler->getViewFactory()->addNamespace(
            static::$viewNamespace,
            $this->getPath().DIRECTORY_SEPARATOR.'views'
        );
    }
}
