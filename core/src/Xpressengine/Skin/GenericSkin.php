<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Skin;

use Illuminate\Contracts\Support\Renderable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xpressengine\Storage\File;

/**
 * 편의를 위해 AbstractSkin을 확장한 클래스. 특정 디렉토리에 지정된 형식에 맞게 테마에 필요한 파일들을 구성한 후,
 * 이 클래스의 $path에 디렉토리의 경로를 지정하여 사용한다.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class GenericSkin extends AbstractSkin
{
    /**
     * @var string 스킨 디렉토리 경로
     */
    protected static $path = '';

    /**
     * @var string 템플릿 파일 보관 디렉토리 경로
     */
    protected static $viewDir = 'views';

    /**
     * @var array
     */
    protected static $info = null;

    /**
     * desktop 버전 지원 여부를 조사한다.
     *
     * @return bool
     */
    public static function supportDesktop()
    {
        return static::info('support.desktop');
    }

    /**
     * mobile 버전 지원 여부를 조사한다.
     *
     * @return bool
     */
    public static function supportMobile()
    {
        return static::info('support.mobile');
    }

    /**
     * get path, example: 'plugins/myplugin/skin'
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
     * 스킨을 출력한다.
     * 만약 view 이름과 동일한 메소드명이 존재하면 그 메소드를 호출한다.
     *
     * @return Renderable|string
     */
    public function render()
    {
        $view = $this->view;
        $method = ucwords(str_replace(['-', '_', '.'], ' ', $view));
        $method = lcfirst(str_replace(' ', '', $method));

        // for php7
        if ($method === 'list') {
            $method = 'listView';
        }

        if (method_exists($this, $method)) {
            return $this->$method($view);
        } else {
            return $this->renderBlade($view);
        }
    }

    /**
     * 블레이드 템플릿을 사용하여 스킨을 출력한다.
     *
     * @param null|string $view view name
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    protected function renderBlade($view = null)
    {
        if ($view === null) {
            $view = $this->view;
        }

        return view(
            $this->view($view),
            $this->data,
            [
                '_skin' => static::class,
                '_config' => $this->config
            ]
        );
    }


    /**
     * 스킨 설정을 위한 화면에 출력될 html 반환
     *
     * @param array $config 설정값
     *
     * @return mixed
     */
    public function renderSetting(array $config = [])
    {
        if ($config === null) {
            $config = $this->setting();
        }
        $view = $this->info('setting');
        $_skin = static::class;

        if (is_null($view)) {
            return null;
        } elseif (is_string($view)) {
            return view($this->view($view), compact('config', '_skin'));
        } elseif (is_array($view)) {
            return $this->makeConfigView($view, $config);
        }
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
        $configId = array_get($inputs, '_configId');

        // 파일만 별도 처리
        foreach ($inputs as $key => $item) {
            if ($item instanceof UploadedFile) {
                array_set($inputs, $key, $this->saveFile($configId, $key, $item));
            } elseif ($item === null) {
                unset($inputs[$key]);
            }
        }
        return $inputs;
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
            $oldFile = app('xe.storage')->find($oldFileId);
            if ($oldFile) {
                app('xe.storage')->remove($oldFile);
            }
        }

        // save new file
        $file = app('xe.storage')->upload(
            $file,
            config('xe.theme.upload.path').$configId,
            config('xe.theme.upload.disk')
        );
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
     * info.php에 등록돼 있는 setting 폼 리스트를 가져와 form을 생성하여 반환한다.
     *
     * @param array $info setting form info
     * @param array $old  old config data
     *
     * @return string
     */
    protected function makeConfigView(array $info, $old)
    {
        return uio('form', ['type'=> 'fieldset', 'class' => $this->getId(), 'inputs' => $info, 'value' => $old]);
    }

    /**
     * 스킨의 asset 파일 주소(url)를 반환한다. 템플릿 파일 작성시 편의를 위해 사용한다.
     *
     * @param string $path   path가 주어질 경우 주어진 파일의 URL을 반환한다. path는 스킨의 assets 디렉토리 내에서의 상대 경로이어야 한다.
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
        $dir = static::$viewDir ? '.'.static::$viewDir : '';
        $view = str_replace('/', '.', static::$path)."$dir.$view";
        return $view;
    }
}
