<?php
/**
 *  This file is part of the Xpressengine package.
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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xpressengine\Plugin\SupportInfoTrait;
use View;

/**
 * 편의를 위해 AbstractSkin을 확장한 클래스. 특정 디렉토리에 지정된 형식에 맞게 테마에 필요한 파일들을 구성한 후,
 * 이 클래스의 $path에 디렉토리의 경로를 지정하여 사용한다.
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class GenericSkin extends AbstractSkin
{
    use SupportInfoTrait;

    /**
     * @var string 스킨 디렉토리 경로
     */
    protected static $path = '';

    /**
     * @var string 템플릿 파일 보관 디렉토리 경로
     */
    protected static $viewDir = 'views';

    /**
     * @var string
     */
    protected $file;

    /**
     * @var GenericSkin $defaultSkin
     */
    protected static $defaultSkin;

    /**
     * 스킨에 data를 지정할 때 기본 스킨이 있을 경우 기본 스킨에도 같은 data를 지정해서 추가한 스킨에 출력할 파일이 없을 경우
     * 기본 스킨이 정상적으로 동작할 수 있도록 한다.
     *
     * @param mixed $data 지정할 데이터
     *
     * @return AbstractSkin
     */
    public function setData($data)
    {
        if (static::$defaultSkin && static::class !== get_class(static::$defaultSkin)) {
            static::$defaultSkin->setData($data);
        }

        return parent::setData($data);
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
        }

        if (View::exists(self::view($view)) === false &&
            (static::$defaultSkin && static::class !== get_class(static::$defaultSkin))
        ) {
            return static::$defaultSkin->setView($view)->render();
        }

        return $this->renderBlade($view);
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
        $mergeData = [
            '_skin' => static::class,
            '_config' => $this->config
        ];

        if (!$view && $this->file) {
            return view()->file($this->file, $this->data, $mergeData);
        }

        if ($view === null) {
            $view = $this->view;
        }

        return view($this->view($view), $this->data, $mergeData);
    }

    /**
     * set view file path
     *
     * @param string $file view file path
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
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
            } elseif ($item === '__delete_file__') {
                $this->removeFile($key);
                $inputs[$key] = null;
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
        $this->removeFile($key);

        // save new file
        $file = app('xe.storage')->upload(
            $file,
            config('xe.skin.storage.path').$configId,
            null,
            config('xe.skin.storage.disk')
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
     * setting 과정에서 upload되는 파일을 저장한다.
     *
     * @param string $key config field key
     *
     * @return array
     */
    protected function removeFile($key)
    {
        $oldFileId = null;
        if ($oldSetting = $this->setting()) {
            $oldFileId = $oldSetting[$key]['id'] ?? null;
        }

        // remove old file
        if ($oldFileId !== null) {
            $oldFile = app('xe.storage')->find($oldFileId);
            if ($oldFile) {
                app('xe.storage')->delete($oldFile);
            }
        }
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
        if (method_exists(static::class, 'getPath')) {
            $path = static::getPath().'/assets/'.$path;
        }

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
        $dir = static::$viewDir ? '.' . static::$viewDir : '';
        $view = str_replace('/', '.', static::$path) . "$dir.$view";

        return $view;
    }

    /**
     * 기본 스킨을 주입
     *
     * @param AbstractSkin $skin default skin
     *
     * @return void
     */
    public function setDefaultSkin(AbstractSkin $skin)
    {
        static::$defaultSkin = $skin;
    }
}
