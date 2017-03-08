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

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Storage\File;

/**
 * 이 클래스는 Xpressengine에서 테마를 간편하게 구현할 수 있도록 제공하는 클래스이다. 특정 디렉토리에 지정된 형식에 맞게 테마에 필요한 파일들을 구성한 후,
 * 이 클래스의 $path에 디렉토리의 경로를 지정하여 사용한다.
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class GenericTheme extends AbstractTheme
{
    /**
     * @var string 테마를 정의한 디렉토리 경로, 플러그인디렉토리명을 포함한 디렉토리 경로를 지정해야 한다. ex) 'myplugin/theme'
     */
    protected static $path = null;

    /**
     * @var string 템플릿 파일을 저장하고 있는 디렉토리의 경로, 테마 디렉토리내 상대경로를 지정해야 한다.
     */
    protected static $viewsDir = "views";

    /**
     * @var array
     */
    protected static $info = null;

    /**
     * 테마가 desktop 버전을 지원하는지 조사한다.
     *
     * @return bool desktop 버전을 지원할 경우 true
     */
    public static function supportDesktop()
    {
        return static::info('support.desktop');
    }

    /**
     * 테마가 mobile 버전을 지원하는지 조사한다.
     *
     * @return bool mobile 버전을 지원할 경우 true
     */
    public static function supportMobile()
    {
        return static::info('support.mobile');
    }

    /**
     * get path, example: 'plugins/myplugin/theme'
     *
     * @return mixed
     */
    public static function getPath()
    {
        return trim(str_replace(base_path(), '', plugins_path(static::$path)), DIRECTORY_SEPARATOR);
    }

    /**
     * retrieve theme info from info.php file
     *
     * @param string $key     info field
     * @param mixed  $default default value
     *
     * @return array
     */
    public static function info($key = null, $default = null)
    {
        if (static::$info === null) {
            static::$info = include(base_path(static::getPath().'/'.'info.php'));
        }

        if ($key !== null) {
            return array_get(static::$info, $key, $default);
        }
        return static::$info;
    }

    /**
     * 이 테마가 설정페이지를 제공하는 테마인지 조회한다.
     *
     * @return bool
     */
    public static function hasSetting()
    {
        return static::info('setting') !== null;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $config = $this->setting();

        $theme = $_theme = static::class;

        $view = $this->view($this->info('view', 'theme'));

        return static::$handler->getViewFactory()->make($view, compact('config', '_theme', 'theme'));
    }

    /**
     * 각 테마는 편집 페이지에서 편집할 수 있는 템플릿파일(blade)이나 css 파일 목록을 지정한다.
     * 이 메소드는 그 파일 목록을 조회한다.
     *
     * @return array
     */
    public function getEditFiles()
    {
        $path = base_path($this->getPath());
        $editable = $this->info('editable');

        $files = [];
        foreach ($editable as $file) {
            $files[$file] = $path.DIRECTORY_SEPARATOR.static::$viewsDir.DIRECTORY_SEPARATOR.$file;
        }
        return $files;
    }

    /**
     * return content of setting page
     *
     * @param ConfigEntity $config config data
     *
     * @return \Illuminate\Contracts\View\View|void
     */
    public function renderSetting(ConfigEntity $config = null)
    {
        if ($config === null) {
            $config = $this->setting();
        }
        $view = $this->info('setting', 'setting');
        $theme = static::class;

        if (is_string($view)) {
            return static::$handler->getViewFactory()->make($this->view($view), compact('config', 'theme'));
        } elseif (is_array($view)) {
            return $this->makeConfigView($view, $config);
        }
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
        $configId = array_get($config, '_configId');

        // 파일만 별도 처리
        foreach ($config as $key => $item) {
            if ($item instanceof UploadedFile) {
                array_set($config, $key, $this->saveFile($configId, $key, $item));
            } elseif ($item === null) {
                unset($config[$key]);
            }
        }
        return $config;
    }

    /**
     * setting 과정에서 upload되는 파일을 저장한다.
     *
     * @param string       $configId config id
     * @param string       $key      config field key
     * @param UploadedFile $file     file
     *
     * @return array
     */
    protected function saveFile($configId, $key, UploadedFile $file)
    {
        $oldSetting = $this->setting();
        $oldFileId = $oldSetting->get("$key.id");

        // remove old file
        if ($oldFileId !== null) {
            $oldFile = File::find($oldFileId);
            if ($oldFile) {
                app('xe.storage')->remove($oldFile);
            }
        }

        // save new file
        $file = app('xe.storage')->upload(
            $file,
            config('xe.theme.storage.path').$configId,
            $key,
            config('xe.theme.storage.disk')
        );
        app('xe.storage')->bind($configId, $file);

        $saved = [
            'id' => $file->id,
            'filename' => $file->clientname
        ];

        $mediaFile = null;
        if (app('xe.media')->is($file)) {
            $mediaFile = app('xe.media')->make($file);
            $saved['path'] = $mediaFile->url();
        }

        return $saved;
    }

    /**
     * 삭제할 테마 설정에서 업로드했던 파일들을 삭제한다.
     *
     * @param ConfigEntity $config config data
     *
     * @return void
     */
    public function deleteSetting(ConfigEntity $config)
    {
        $configId = $config->get('_configId');

        // delete saved files
        $files = File::getByFileable($configId);
        foreach ($files as $file) {
            app('xe.storage')->remove($file);
        }
    }

    /**
     * info.php에 등록돼 있는 setting 폼 리스트를 가져와 form을 생성하여 반환한다.
     *
     * @param array        $info setting form info
     * @param ConfigEntity $old  old config data
     *
     * @return string
     */
    protected function makeConfigView(array $info, ConfigEntity $old)
    {
        return uio('form', ['class' => $this->getId(), 'inputs' => $info, 'value' => $old]);
    }


    /**
     * get and set config
     *
     * @param ConfigEntity|null $config config data
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
     * 테마의 asset 파일 주소(url)를 반환한다. 템플릿 파일 작성시 편의를 위해 사용한다.
     *
     * @param string $path   path가 주어질 경우 주어진 파일의 URL을 반환한다. path는 테마의 assets 디렉토리 내에서의 상대 경로이어야 한다.
     * @param string $secure https 여부
     *
     * @return string
     */
    public static function asset($path, $secure = null)
    {
        $path = static::getPath().'/assets/'.$path;
        return asset($path, $secure);
    }

    /**
     * view name을 반환한다. 템플릿 파일 작성시 편의를 위해 사용한다.
     *
     * @param string $view view name
     *
     * @return string
     */
    public static function view($view)
    {
        $view = str_replace('/', '.', static::$path).".".static::$viewsDir.".$view";

        $handler = static::$handler;

        view()->composer($view, function(\Illuminate\View\View $viewObj) use ($handler) {
            if($handler->hasCache($viewObj->getPath())) {
                $viewObj->setPath($handler->getCachePath($viewObj->getPath()));
            }
        });

        return $view;
    }
}
