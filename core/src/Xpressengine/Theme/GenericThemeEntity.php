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
 * ThemeEntity는 하나의 테마에 대한 정보를 가지고 있는 클래스이다.
 * XpressEngine에 등록된 테마들의 정보를 ThemeEntity로 생성하여 처리한다.
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class GenericThemeEntity implements ThemeEntityInterface
{
    /**
     * @var ThemeHandler
     */
    protected static $handler;

    /**
     * @var string
     */
    protected static $viewNamespace = '_theme';

    /**
     * @var string theme id
     */
    protected $id;

    /**
     * @var string theme path
     */
    protected $path;

    /**
     * @var AbstractTheme object of theme
     */
    protected $object;

    /**
     * @var array
     */
    protected $info;

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
     * ThemeEntity constructor.
     *
     * @param string $id   theme id
     * @param string $path theme directory path
     */
    public function __construct($id, $componentInfo)
    {
        $this->id = $id;
        $this->path = $componentInfo['path'];
        unset($componentInfo['path']);

        $info = include(base_path($this->path.'/'.'info.php'));
        $this->resolveInfo($info, $componentInfo);
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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * get theme title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->info('name');
    }

    /**
     * get theme's description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->info('description');
    }

    /**
     * 각 테마는 편집 페이지에서 편집할 수 있는 템플릿파일(blade)이나 css 파일 목록을 지정한다.
     * 이 메소드는 그 파일 목록을 조회한다.
     *
     * @return array
     */
    public function getEditFiles()
    {
        $path = base_path($this->path.DIRECTORY_SEPARATOR.'views');
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
     * get screenshot of theme
     *
     * @return mixed
     */
    public function getScreenshot()
    {
        return $this->info('screenshot');
    }

    public function support($version)
    {
        if ($version === 'desktop') {
            return $this->supportDesktop();
        } elseif ($version === 'mobile') {
            return $this->supportMobile();
        }
    }

    /**
     * 테마가 desktop 버전을 지원하는지 조사한다.
     *
     * @return bool desktop 버전을 지원할 경우 true
     */
    public function supportDesktop()
    {
        return $this->info('support.desktop');
    }

    /**
     * 테마가 desktop 버전만을 지원하는지 조사한다.
     *
     * @return bool desktop 버전만을 지원할 경우 true
     */
    public function supportDesktopOnly()
    {
        return $this->info('support.desktop') === true && $this->info('support.mobile') === false;
    }

    /**
     * 테마가 mobile 버전을 지원하는지 조사한다.
     *
     * @return bool mobile 버전을 지원할 경우 true
     */
    public function supportMobile()
    {
        return $this->info('support.desktop');
    }

    /**
     * 테마가 mobile 버전만을 지원하는지 조사한다.
     *
     * @return bool mobile 버전만을 지원할 경우 true
     */
    public function supportMobileOnly()
    {
        return $this->info('support.desktop') === false && $this->info('support.mobile') === true;
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
            'path' => $this->path,
            'title' => $this->getTitle(),
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
        $config = $this->config();

        $this->registerViewNamespace();

        $view = $this->viewname('view', 'theme');
        return static::$handler->getViewFactory()->make($view, compact('config'));
    }

    /**
     * return editConfigView
     *
     * @param ConfigEntity $config
     *
     * @return \Illuminate\Contracts\View\View|void
     */
    public function editConfig(ConfigEntity $config = null)
    {
        if($config === null) {
            $config = $this->config();
        }
        $view = array_get($this->info, 'config', 'config');

        $this->registerViewNamespace();

        if(is_string($view)) {
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
    public function updateConfig(array $config)
    {
        $oldConfig = $this->config();

        // $config = ['_configId', ...]
        return $config;
    }

    /**
     * get and set config
     *
     * @param ConfigEntity $config
     *
     * @return ConfigEntity
     */
    public function config(ConfigEntity $config = null) {
        if($config !== null) {
            $this->config = $config;
        }
        return $this->config;
    }

    /**
     * get theme info
     *
     * @param null $key
     *
     * @return array
     */
    protected function info($key = null)
    {
        if($key !== null) {
            return array_get($this->info, $key);
        }
        return $this->info;
    }

    /**
     * resolve theme info
     *
     * @param $info
     * @param $componentInfo
     *
     * @return void
     */
    protected function resolveInfo($info, $componentInfo)
    {
        // resolve screenshot
        $screenshot = array_get($info, 'screenshot');
        if($screenshot !== null) {
            array_set($info, 'screenshot', asset($this->path.'/'.$screenshot));
        }

        $this->info = array_merge($info, $componentInfo);
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
        return static::$viewNamespace.'::'.array_get($this->info, $name, $default);
    }

    /**
     * makeConfigView
     *
     * @param array $info
     * @param ConfigEntity $config
     *
     * @return string
     */
    private function makeConfigView(array $info, ConfigEntity $config)
    {
        return '...';
    }

    /**
     * registerViewNamespace
     *
     * @return void
     */
    private function registerViewNamespace()
    {
        // register '_theme::' view namespace
        static::$handler->getViewFactory()->addNamespace(
            static::$viewNamespace,
            $this->path.DIRECTORY_SEPARATOR.'views'
        );
    }
}
