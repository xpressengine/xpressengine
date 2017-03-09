<?php
/**
 * PluginEntity class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Xpressengine\Plugin\Exceptions\PluginFileNotFoundException;
use Xpressengine\Plugin\PluginHandler as Plugin;

/**
 * 이 클래스는 XE에 존재하는 플러그인의 Entity 클래스이다. 이 클래스는 XE3에서 플러그인당 하나씩 생성된다.
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 *
 * @method void activate($installedVersion = null)
 * @method void deactivate($installedVersion = null)
 * @method void install()
 * @method boolean checkInstalled($currentVersion = null)
 * @method void update()
 * @method boolean checkUpdated($currentVersion = null)
 * @method void uninstall()
 * @method string getSettingsURI()
 * @method void boot()
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class PluginEntity implements Arrayable, Jsonable
{
    /**
     * @var PluginCollection
     */
    public static $collection;

    /**
     * 플러그인의 ID, 플러그인의 저장된 디렉토리명과 동일하다.
     *
     * @var string
     */
    protected $id;

    /**
     * 플러그인의 경로
     *
     * @var string
     */
    protected $pluginFile;

    /**
     * 플러그인의 클래스명(네임스페이스 포함)
     *
     * @var string|AbstractPlugin
     */
    protected $class;

    /**
     * 플러그인의 인스턴스.
     *
     * @var AbstractPlugin
     */
    protected $object;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var null
     */
    protected $installedVersion = null;

    /**
     * 플러그인에 포함된 ComponentInterface 의 설정 정보
     *
     * @var array
     */
    protected $componentInfo;

    /**
     * @var array
     */
    protected $metaData;

    protected $remoteData = null;

    /**
     * 플러그인의 정보를 전달받아 Entity 클래스를 생성한다.
     *
     * @param string         $id       플러그인의 ID
     * @param string         $path     플러그인의 경로
     * @param string         $class    플러그인의 클래스명
     * @param array          $metaData 플러그인 부가정보
     * @param AbstractPlugin $object   플러그인의 인스턴스
     */
    public function __construct($id, $path, $class, $metaData, $object = null)
    {
        $this->id = $id;
        $this->pluginFile = $path;
        $this->class = $class;
        $this->metaData = $metaData;
        $this->object = $object;

        $this->status = Plugin::STATUS_DEACTIVATED;
    }

    /**
     * 플러그인의 클래스명을 반환한다.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * 플러그인의 ID를 반환한다.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 플러그인의 인스턴스를 반환한다.
     *
     * @return AbstractPlugin
     */
    public function getObject()
    {
        if (isset($this->object) && is_a($this->object, 'Xpressengine\Plugin\AbstractPlugin')) {
            return $this->object;
        } else {
            if (file_exists($this->pluginFile) === false) {
                throw new PluginFileNotFoundException(['path' => str_replace(base_path(), '', $this->pluginFile)]);
            }
            require_once($this->pluginFile);

            // reigster each plugin's autoload if autoload.php exist
            $this->registerPluginAutoload();

            $this->object = new $this->class();
            return $this->object;
        }
    }

    /**
     * 해당 플러그인의 설치 경로를 반환한다.
     * path가 주어질 경우, 주어진 path정보를 추가하여 반환한다.
     *
     * @param string $path path
     *
     * @return string
     */
    public function getPath($path = '')
    {
        $pluginObj = $this->getObject();
        return $pluginObj->path($path);
    }

    /**
     * 플러그인이 활성화된 상태인지 조사한다.
     *
     * @return bool
     */
    public function isActivated()
    {
        return $this->status === Plugin::STATUS_ACTIVATED;
    }

    /**
     * 플러그인이 비활성화된 상태인지 조사한다
     *
     * @return bool
     */
    public function isDeactivated()
    {
        return $this->status === Plugin::STATUS_DEACTIVATED;
    }

    /**
     * 플러그인 상태를 조회한다.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * 플러그인 상태를 지정한다.
     *
     * @param string $status 플러그인 상태
     *
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * 플러그인의 아이콘 url을 반환한다.
     *
     * @return string
     */
    public function getIcon()
    {
        $icon = $this->getMetaData('extra.xpressengine.icon');

        if ($icon === null) {
            return null;
        }

        $path = $this->getPath($icon);

        if (realpath($path) !== false) {
            $class = $this->class;
            $file = $class::asset($icon);
            return $file;
        }
        if (realpath(base_path($icon)) !== false) {
            return asset($icon);
        }

        return null;
    }

    /**
     * 플러그인의 아이콘 url을 반환한다.
     *
     * @return string
     */
    public function getScreenshots()
    {
        $screenshots = $this->getMetaData('extra.xpressengine.screenshots');

        if ($screenshots === null || empty($screenshots)) {
            return [];
        }

        $resolved = [];
        foreach ($screenshots as $screenshot) {
            $path = $this->getPath($screenshot);

            if (realpath($path) !== false) {
                $class = $this->class;
                $file = $class::asset($screenshot);
                $resolved[] = $file;
            }
            if (realpath(base_path($screenshot)) !== false) {
                $resolved[] = asset($screenshot);
            }
        }
        return $resolved;
    }

    /**
     * 플러그인의 설치 버전을 조회한다. 설치 버전은 XpressEngine에 적용되어 있는 플러그인의 버전이다.
     * 한번도 활성화된 적이 없다면 다운로드된 플러그인의 버전을 반환한다.
     *
     * @return string
     */
    public function getInstalledVersion()
    {
        return $this->installedVersion;
    }

    /**
     * 플러그인의 설치 버전을 지정한다.
     *
     * @param string $version 설치버전
     *
     * @return void
     */
    public function setInstalledVersion($version)
    {
        $this->installedVersion = $version;
    }

    /**
     * 자료실에 등록된 자료 정보가 있는지 검사
     *
     * @return bool
     */
    public function hasRemoteData()
    {
        if ($this->remoteData !== null) {
            return true;
        }
        return false;
    }

    /**
     * 자료실에 등록된 플러그인의 정보를 설정한다.
     *
     * @param array $data 자료실에 등록된 플러그인 정보
     *
     * @return void
     */
    public function setRemoteData($data)
    {
        $this->remoteData = $data;
    }

    /**
     * 자료실에 등록된 플러그인의 정보가 설정돼 있을 경우 반환한다.
     *
     * @return null
     */
    public function getRemoteData()
    {
        return $this->remoteData;
    }

    /**
     * 플러그인의 새로운 업데이트가 서버에 다운로드 되어 있는 상태인지 확인한다.
     *
     * @return boolean 설치가 필요할 경우 true를 반환
     */
    public function needUpdateInstall()
    {
        $installedVersion = $this->getInstalledVersion();
        return !$this->checkInstalled($installedVersion) || !$this->checkUpdated($installedVersion);
    }

    /**
     * 플러그인의 업데이트가 Xpressengine의 서버에 존재하고, 아직 다운로드되어 있지 않은 상태인지 체크한다.
     *
     * @return boolean 새버전이 서버에 존재할 경우 true를 반환
     */
    public function hasUpdate()
    {
        if ($this->hasRemoteData()) {
            return version_compare($this->getLatestVersion(), $this->getVersion(), '>');
        }

        return false;
    }

    /**
     * 플러그인의 최신 업데이트 버전을 Xpressengine의 서버에서 조회하여 반환한다.
     *
     * @return string latest version
     */
    public function getLatestVersion()
    {
        if ($this->hasRemoteData()) {
            return data_get($this->remoteData, 'latest_release.version');
        }
        return null;
    }

    /**
     * 플러그인의 메타정보를 지정한다.
     *
     * @param array $data 메타정보
     *
     * @return void
     */
    public function setMetaData(array $data)
    {
        $this->metaData = $data;
    }

    /**
     * 플러그인의 메타데이터 정보를 조회한다. 만약 필드명이 주어질 경우 해당 필드명의 정보를 조회한다.
     *
     * @param string $field 조회할 필드명
     *
     * @return array|mixed
     */
    public function getMetaData($field = null)
    {
        if ($field === null) {
            return $this->metaData;
        } else {
            return array_get($this->metaData, $field);
        }
    }

    /**
     * 플러그인 제목을 조회한다.
     *
     * @return array|mixed
     */
    public function getTitle()
    {
        return $this->getMetaData('extra.xpressengine.title');
    }

    /**
     * 플러그인 설명을 조회한다.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getMetaData('description');
    }

    /**
     * Support 정보를 조회한다. 만약 필드명이 주어질 경우 해당 필드명의 정보를 조회한다.
     *
     * @param string $field 조회할 필드명
     *
     * @return array|string
     */
    public function getSupport($field = null)
    {
        $metaData = $this->getMetaData();

        $support = array_get($metaData, 'support');

        if ($support === null) {
            if ($field === null) {
                return [];
            } else {
                return null;
            }
        }

        if ($field === null) {
            return $support;
        } else {
            return array_get($support, $field, null);
        }
    }

    /**
     * 플러그인의 readme 파일 내용을 반환한다.
     *
     * @return string
     */
    public function getReadMe()
    {

        if ($this->hasRemoteData()) {
            return data_get($this->remoteData, 'details', '');
        }

        $file = $this->getPath('README.md');

        if (!file_exists($file)) {
            return '';
        } else {
            return nl2br(file_get_contents($file));
        }
    }

    /**
     * 플러그인의 change log 파일 내용을 반환한다.
     *
     * @return string
     */
    public function getChangeLog()
    {

        if ($this->hasRemoteData()) {
            $logs = '';
            foreach (data_get($this->remoteData, 'releases', []) as $release) {
                $content = data_get($release, 'parsed_changelog') ?: '-';
                $logs .= "<dt>{$release->version}</dt><dd>$content</dd>";
            }
            return "<dl>$logs</dl>";
        }

        $file = $this->getPath('CHANGELOG.md');

        if (!file_exists($file)) {
            return '';
        } else {
            return nl2br(file_get_contents($file));
        }
    }

    /**
     * getStoreLink
     *
     * @return string
     */
    public function getStoreLink()
    {
        if ($this->hasRemoteData()) {
            return data_get($this->remoteData, 'link');
        }
        return '';
    }

    /**
     * 플러그인의 이름을 조회한다. 이름은 composer에서 사용하는 패키지명과 일치한다.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getMetaData('name');
    }

    /**
     * 플러그인의 검색 키워드를 조회한다.
     *
     * @return array
     */
    public function getKeywords()
    {
        return $this->getMetaData('keywords');
    }

    /**
     * 플러그인 제작자 정보를 조회한다.
     *
     * @return array
     */
    public function getAuthors()
    {
        $authors = $this->getMetaData('authors');
        if ($authors === null) {
            return [];
        }

        return $authors;
    }

    /**
     * 플러그인 제작자 정보를 조회한다. 제작자가 여러명일 경우 첫번째 제작자만 반환한다.
     *
     * @return array
     */
    public function getAuthor()
    {
        $authors = $this->getAuthors();

        if (empty($authors)) {
            return null;
        }

        return array_shift($authors);
    }

    /**
     * 플러그인 버전을 조회한다.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->getMetaData('version');
    }

    /**
     * 플러그인의 라이선스 정보를 조회한다.
     *
     * @return string
     */
    public function getLicense()
    {
        return $this->getMetaData('license');
    }

    /**
     * 플러그인의 의존성정보를 조회한다.
     *
     * @return string[]
     */
    public function getDependencies()
    {
        // 이미 dependency 자료는 모두 composer를 통해 설치돼 있다고 가정한다.
        $dependencies = $this->getMetaData('require');
        if ($dependencies === null) {
            $dependencies = [];
        }

        $collection = $this->getCollection();
        $dependencyPlugins = [];
        foreach ($dependencies as $dependency => $version) {
            list($venacdor, $id) = explode('/', $dependency);
            $entity = $collection->get($id);
            if ($entity !== null && $entity->getName() === $dependency) {
                $dependencyPlugins[$id] = $entity;
            }
        }
        return $dependencyPlugins;
    }

    /**
     * 플러그인이 소유한 컴포넌트 목록을 조회한다. type이 지정돼 있을 경우 해당 type의 컴포넌트를 조회한다.
     *
     * @param string $type component type
     *
     * @return array
     */
    public function getComponentList($type = null)
    {
        $componentList = $this->getMetaData('extra.xpressengine.component');
        if ($componentList === null) {
            $componentList = [];
        }

        if ($type === null) {
            return $componentList;
        } else {
            $componentsFetched = [];
            array_walk(
                $componentList,
                function ($info, $key) use (&$componentsFetched, $type) {
                    $componentType = $this->getComponentType($key);
                    if ($componentType === $type) {
                        $componentsFetched[$key] = $info;
                    }
                }
            );
            return $componentsFetched;
        }
    }

    /**
     * call component boot interface
     *
     * @return void
     */
    public function bootComponents()
    {
        foreach ($this->getComponentList() as $id => $info) {
            /** @var \Xpressengine\Plugin\ComponentInterface $class */
            $class = $info['class'];
            $class::boot();
        }
    }

    /**
     * 주어진 컴포넌트 아이디에서 컴포넌트 타입정보를 조회한다.
     *
     * @param string $id 컴포넌트 아이디
     *
     * @return string
     */
    public static function getComponentType($id)
    {
        $keyArr = explode('/', $id);

        array_pop($keyArr);
        $type = array_pop($keyArr);

        return $type;
    }

    /**
     * 플러그인 정보를 array형식으로 반환한다.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'path' => $this->pluginFile,
            'class' => $this->class,
            'status' => $this->getStatus(),
            'metaData' => $this->metaData
        ];
    }

    /**
     * 플러그인 정보를 json 형식으로 반환한다.
     *
     * @param  int $options JSON Decode options.
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * 이 PluginEntity의 메소드가 호출될 경우, 플러그인 인스턴스의 메소드가 호출되도록 한다.
     *
     * @param string $method    호출될 메소드
     * @param mixed  $arguments 호출시 파라메터
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->getObject(), $method), $arguments);
    }

    /**
     * getCollection
     *
     * @return PluginCollection
     */
    public static function getCollection()
    {
        return static::$collection;
    }

    /**
     * PluginCollection을 지정한다.
     *
     * @param PluginCollection $collection plugin collection
     *
     * @return void
     */
    public static function setCollection($collection)
    {
        static::$collection = $collection;
    }

    /**
     * 플러그인이 composer autoload 파일을 가지고 있을 경우 autoload를 등록한다.
     * autoload 파일을 각 플러그인 디렉토리 내에 vendor/autoload.php 파일이다.
     *
     * @return void
     */
    protected function registerPluginAutoload()
    {
        $autoloadFile = dirname($this->pluginFile).'/vendor/autoload.php';
        if (file_exists($autoloadFile)) {
            require $autoloadFile;
        }
    }

    /**
     * 개발모드 플러그인인지 검사한다. vendor 디렉토리를 가지고 있는지의 유무로 판단한다.
     *
     * @return bool
     */
    public function isDevelopMode()
    {
        $vendorDir = dirname($this->pluginFile).'/vendor';
        if (file_exists($vendorDir)) {
            return true;
        }
        return false;
    }
}
