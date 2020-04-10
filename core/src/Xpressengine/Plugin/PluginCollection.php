<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin;

use ArrayIterator;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use IteratorAggregate;
use Traversable;
use Xpressengine\Config\ConfigManager;

/**
 * 설치된 플러그인들의 정보를 저장하는 저장소
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class PluginCollection implements Countable, Arrayable, IteratorAggregate, Jsonable
{

    /**
     * @var PluginEntity[]
     */
    protected $plugins;

    /**
     * @var array
     */
    protected $statusList;

    /**
     * @var ConfigManager
     */
    protected static $configManager;

    /**
     * Constructor
     *
     * @param array $plugins PluginEntity items
     */
    public function __construct(array $plugins)
    {
        $this->plugins = $plugins;

        $this->initialize();
    }

    /**
     * 설치된 플러그인들의 정보를 초기화 한다. 만약 cache에 저장된 정보가 있을 경우 cache로부터 저장된 정보를 가져오며,
     * 캐싱된 정보가 없거나 refresh가 설정돼 있을 경우 다시 플러그인 디렉토리를 스캔하여 정보를 생성한다.
     *
     * @return void
     *
     * @todo 가시성 변경
     */
    public function initialize()
    {
        // set status of plugins
        foreach ($this->getStatusList() as $id => $info) {
            if (array_has($this->plugins, $id)) {
                $plugin = $this->get($id);
                $plugin->setStatus($info['status']);
                $plugin->setInstalledVersion($info['version']);
            }
        }
    }

    /**
     * 플러그인 상태 정보 반환
     *
     * @return array
     */
    protected function getStatusList()
    {
        if (!$this->statusList) {
            $this->statusList = static::$configManager->getVal('plugin.list', []);
        }

        return $this->statusList;
    }

    /**
     * config manager를 설정한다.
     *
     * @param ConfigManager $config config manager
     *
     * @return void
     */
    public static function setConfig($config)
    {
        static::$configManager = $config;
    }

    /**
     * 플러그인 디렉토리를 스캔하여 플러그인 정보를 새로 갱신한다.
     *
     * @return void
     *
     * @deprecated since 3.0.1
     */
    protected function refresh()
    {
        //
    }

    /**
     * 주어진 id의 플러그인을 반환한다.
     *
     * @param string $id 플러그인 아이디
     *
     * @return PluginEntity
     */
    public function get($id)
    {
        return array_get($this->plugins, $id);
    }

    /**
     * 주어진 id에 해당하는 플러그인 목록을 조회한다.
     *
     * @param array $ids 플러그인 아이디 목록
     *
     * @return PluginEntity[]
     */
    public function getList($ids = null)
    {
        if ($ids === null) {
            return $this->plugins;
        }
        return Arr::only($this->plugins, (array) $ids);
    }

    /**
     * 주어진 검색 정보 사용하여 플러그인을 조회한다.
     * status, keyword, 소유한 component를 검색 필드로 사용할 수 있다.
     *
     * @param array $searchField 검색 정보
     *
     * @return PluginEntity[]
     */
    public function fetch(array $searchField)
    {
        $plugins = $this->plugins;

        $status = array_get($searchField, 'status');
        if ($status !== null) {
            $plugins = $this->fetchByStatus($status, $plugins);
        }

        $searchword = array_get($searchField, 'keyword');
        if ($searchword !== null) {
            $plugins = $this->fetchByKeyword($searchword, $plugins);
        }

        $component = array_get($searchField, 'component');
        if ($component !== null) {
            $plugins = $this->fetchByComponent($component, $plugins);
        }

        return $plugins;
    }

    /**
     * 플러그인 상태로 플러그인 목록을 조회한다.
     * 만약 두번째 파라메터에 플러그인 목록이 주어진다면, 주어진 플러그인 목록이 조회대상이 된다.
     *
     * @param string         $status  플러그인 상태
     * @param PluginEntity[] $plugins 조회대상 플러그인 목록
     *
     * @return PluginEntity[]
     */
    public function fetchByStatus($status, $plugins = null)
    {
        // TODO: status validation

        $plugins = ($plugins === null) ? $this->plugins : $plugins;

        return array_filter(
            $plugins,
            function ($entity) use ($status) {

                /** @var PluginEntity $entity */
                return $entity->getStatus() === $status;
            }
        );
    }

    /**
     * 키워드로 플러그인 목록을 조회한다. 주어진 키워드를 id, description, keywords, author정보에서 조회한다.
     * 만약 두번째 파라메터에 플러그인 목록이 주어진다면, 주어진 플러그인 목록이 조회대상이 된다.
     *
     * @param string         $searchWord 검색할 키워드
     * @param PluginEntity[] $plugins    조회대상 플러그인 목록
     *
     * @return PluginEntity[]
     */
    public function fetchByKeyword($searchWord, $plugins = null)
    {
        $plugins = $plugins === null ? $this->plugins : $plugins;

        $plugins = array_filter(
            $plugins,
            function ($entity) use ($searchWord) {

                /** @var PluginEntity $entity */
                $subject = implode(
                    ' ',
                    array_flatten(
                        [
                            $entity->getId(),
                            $entity->getTitle(),
                            $entity->getDescription(),
                            $entity->getKeywords(),
                            $entity->getAuthors(),
                        ]
                    )
                );

                if (false !== stripos(strip_tags($subject), $searchWord)) {
                    return true;
                }
                return false;
            }
        );

        return $plugins;
    }

    /**
     * 주어진 컴포넌트 타입을 소유한 플러그인 목록을 조회한다.
     * 만약 두번째 파라메터에 플러그인 목록이 주어진다면, 주어진 플러그인 목록이 조회대상이 된다.
     *
     * @param string         $component 조회할 컴포넌트 타입
     * @param PluginEntity[] $plugins   조회대상 플러그인 목록
     *
     * @return PluginEntity[]
     */
    public function fetchByComponent($component, $plugins = null)
    {
        $plugins = $plugins === null ? $this->plugins : $plugins;

        // TODO: validate $component

        $plugins = array_filter(
            $plugins,
            function ($entity) use ($component) {

                /** @var PluginEntity $entity */
                $componentList = $entity->getComponentList($component);
                return count($componentList) === 0 ? false : true;
            }
        );

        return $plugins;
    }

    /**
     * 주어진 설치 방식(fetched, self-installed)으로 설치된 플러그인 목록을 조회한다.
     * 만약 두번째 파라메터에 플러그인 목록이 주어진다면, 주어진 플러그인 목록이 조회대상이 된다.
     *
     * @param string         $installType 설치 방식
     * @param PluginEntity[] $plugins     조회대상 플러그인 목록
     *
     * @return PluginEntity[]
     */
    public function fetchByInstallType($installType = 'fetched', $plugins = null)
    {
        $plugins = $plugins === null ? $this->plugins : $plugins;

        $plugins = array_filter(
            $plugins,
            function ($entity) use ($installType) {
                /** @var PluginEntity $entity */
                return $entity->isSelfInstalled() === ($installType === 'self-installed');
            }
        );

        return $plugins;
    }

    /**
     * 주어진 아이디를 가진 플러그인이 있는지 조사한다.
     *
     * @param string $id plugin id
     *
     * @return bool
     */
    public function has($id)
    {
        return isset($this->plugins[$id]);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options json_encode option
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * 설치된 플러그인의 갯수를 반환한다.
     *
     * @return int
     */
    public function count()
    {
        return count($this->plugins);
    }

    /**
     * Retrieve an external iterator
     *
     * @return Traversable An instance of an object implementing Iterator Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->plugins);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(
            function ($value) {
                /** @var PluginEntity $value */
                return $value->toArray();
            },
            $this->plugins
        );
    }

    /**
     * 주어진 플러그인 정보를 사용하여 PluginEntity 목록을 생성후 반환한다.
     *
     * @param array $pluginData 플러그인 정보
     *
     * @return PluginEntity[]
     *
     * @deprecated since 3.0.1
     */
    protected function resolvePlugins(array $pluginData)
    {
        //
    }
}
