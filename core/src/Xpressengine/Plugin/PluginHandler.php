<?php
/**
 * AbstractPlugin class. This file is part of the Xpressengine package.
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

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Plugin\Exceptions\CannotDeleteActivatedPluginException;
use Xpressengine\Plugin\Exceptions\PluginAlreadyActivatedException;
use Xpressengine\Plugin\Exceptions\PluginAlreadyDeactivatedException;
use Xpressengine\Plugin\Exceptions\PluginDeactivationFailedException;
use Xpressengine\Plugin\Exceptions\PluginDependencyException;
use Xpressengine\Plugin\Exceptions\PluginNotFoundException;

/**
 * XE에 등록된 플러그인의 전체적인 관리를 담당한다.
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class PluginHandler
{

    /**
     * 활성화 된 상태
     */
    const STATUS_ACTIVATED = 'activated';

    /**
     * 비활성화 된 상태
     */
    const STATUS_DEACTIVATED = 'deactivated';

    /**
     * 플러그인이 package name에 지정해야 하는 vendor
     */
    const PLUGIN_VENDOR_NAME = 'xpressengine-plugin';

    /**
     * the path of directory that all plugins is located
     * 플러그인이 등록돼 있는 디렉토리 경로. 모든 플러그인은 이 디렉토리 안에 존재한다.
     *
     * @var string
     */
    protected $pluginsDir;

    /**
     * 등록된 플러그인을 목록
     *
     * @var PluginCollection
     */
    protected $plugins;

    /**
     * @var PluginProvider
     */
    protected $provider;

    /**
     * 현재 부팅중인 플러그인의 id
     *
     * @var string
     */
    protected $bootingPlugin;

    /**
     * 플러그인 관련 설정 정보를 저장함.
     *
     * @var ConfigManager
     */
    protected $config;

    /**
     * 플러그인 관련 설정 정보의 저장 키
     *
     * @var string
     */
    protected $configKey = 'plugin.list';

    /**
     * view factory
     *
     * @var Factory
     */
    protected $viewFactory;

    /**
     * register
     *
     * @var PluginRegister
     */
    protected $register;

    /**
     * laravel application
     *
     * @var Application
     */
    private $app;

    /**
     * 생성자. 플러그인 관리에 필요한 요소들을 주입받는다.
     *
     * @param string           $pluginsDir  플러그인 디렉토리
     * @param PluginCollection $plugins     플러그인 목록
     * @param PluginProvider   $provider
     * @param Factory          $viewFactory View
     * @param PluginRegister   $register    plugin register
     * @param Application      $app         application
     */
    public function __construct(
        $pluginsDir,
        PluginCollection $plugins,
        PluginProvider $provider,
        Factory $viewFactory,
        PluginRegister $register,
        Application $app
    ) {
        $this->plugins = $plugins;
        $this->pluginsDir = $pluginsDir;
        $this->provider = $provider;
        $this->viewFactory = $viewFactory;
        $this->register = $register;
        $this->app = $app;
    }

    /**
     * config manager를 설정한다.
     *
     * @param ConfigManager $config config manager
     *
     * @return void
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * plugin directory 경로를 반환한다.
     *
     * @return string
     */
    public function getPluginsDir()
    {
        return $this->pluginsDir;
    }

    /**
     * plugin directory 경로를 지정한다.
     *
     * @param string $path 지정할 디렉토리 경로
     *
     * @return void
     */
    public function setPluginsDir($path)
    {
        $this->pluginsDir = $path;
    }

    /**
     * 주어진 플러그인을 활성화한다. 활성화된 플러그인 목록은 XE에 저장된다.
     *
     * @param string $pluginId 활성화 할 플러그인의 id
     *
     * @return void
     */
    public function activatePlugin($pluginId)
    {
        $entity = $this->getPlugin($pluginId);

        $this->updatePlugin($pluginId, false);

        $entity->setStatus(static::STATUS_ACTIVATED);

        // 활성화 된 플러그인의 정보를 config에 기록한다.
        $configs = $this->getPluginsStatus();
        $configs[$pluginId] = [
            'status' => static::STATUS_ACTIVATED,
            'version' => $entity->getVersion()
        ];
        $this->setPluginsStatus($configs);
    }

    /**
     * 주어진 플러그인을 비활성화한다.
     *
     * @param string $pluginId 비활성화 할 플러그인의 id
     *
     * @return void
     */
    public function deactivatePlugin($pluginId)
    {

        $entity = $this->getPlugin($pluginId);

        // 비활성화하려는 플러그인이 활성화되어있는 상태인지 체크한다.
        if ($entity->getStatus() !== static::STATUS_ACTIVATED) {
            throw new PluginAlreadyDeactivatedException();
        }

        // 비활성화하려는 플러그인에 의존하는 활성화 상태인 플러그인이 있는지 검사한다.
        // 만약 의존하는 플러그인이 있다면, 비활성화시키지 않고 예외 처리한다.
        $activateds = $this->getActivatedPlugins();
        foreach ($activateds as $activated) {
            $dependencies = $activated->getDependencies();
            if (in_array($pluginId, $dependencies)) {
                throw new PluginDependencyException();
            }
        }

        // 기존에 설치(활성화)된 적이 있는지 검사한다. 기존에 활성화된 적이 있다면 설치된 버전을 조회한다.
        $configs = $this->getPluginsStatus();
        $config = array_get($configs, $pluginId, []);
        $installedVersion = array_get($config, 'version', null);

        // 플러그인 비활성화. 플러그인을 비활성화할 때마다 각 플러그인의 deactivate() 메소드를 호출해준다.
        // 각 플러그인은 deactivate() 메소드에서 자신이 XE에 설치된 상황을 파악한 후, 비활성화에 필요한 준비를 한다.
        $plugin = $entity->getObject();
        try {
            $plugin->deactivate($installedVersion);
        } catch (\Exception $e) {
            throw new PluginDeactivationFailedException();
        }

        $entity->setStatus(static::STATUS_DEACTIVATED);

        // 비활성화된 플러그인 정보를 config에 기록한다.
        $configs[$pluginId] = [
            'status' => static::STATUS_DEACTIVATED,
            'version' => $entity->getVersion()
        ];

        $this->setPluginsStatus($configs);
    }

    /**
     * 플러그인을 업데이트한다. 내부적으로는 단순히 플러그인을 다시 activate 시킨다.
     *
     * @param string $pluginId 업데이트할 플러그인의 아이디
     * @param bool   $updateStatus true일 경우, 업데이트한 플러그인의 상태를 status에 업데이트한다.
     */
    public function updatePlugin($pluginId, $updateStatus = true)
    {
        $entity = $this->getPlugin($pluginId);

        // 플러그인이 존재하는지 검사한다.
        if ($entity === null) {
            throw new PluginNotFoundException(['pluginName' => $pluginId]);
        }

        // 플러그인이 이미 활성화되어있는 상태인지 체크한다.
        if ($entity->getStatus() === static::STATUS_ACTIVATED) {
            throw new PluginAlreadyActivatedException();
        }

        // 플러그인이 설치되어 있는지 검사한다.
        if ($entity->checkInstalled() === false) {
            $entity->install();
        }

        // 기존에 설치(활성화)된 적이 있는지 검사한다. 기존에 활성화된 적이 있다면 설치된 버전을 조회한다.
        $installedVersion = $entity->getInstalledVersion();

        // 플러그인이 최신업데이트 상태인지 검사하고, 업데이트가 필요하면 업데이트 한다.
        if ($entity->checkUpdated() === false) {
            $entity->update($installedVersion);
        }

        if($updateStatus) {
            // 플러그인의 정보를 config에 기록한다.
            $configs = $this->getPluginsStatus();
            $configs[$pluginId] = [
                'status' => $entity->getStatus(),
                'version' => $entity->getVersion()
            ];
            $this->setPluginsStatus($configs);
        }
    }

    /**
     * 주어진 플러그인을 완전히 삭제한다. 삭제하기 전에 uninstall 작업을 먼저 실행한다.
     *
     * @param string $pluginId 삭제할 플러그인의 id
     *
     * @return void
     * @throws \Exception
     */
    public function deletePlugin($pluginId)
    {
        $entity = $this->getPlugin($pluginId);

        // 우선 활성화 상태인 플러그인인지 체크한다. 활성화 상태라면 삭제하지 않고 예외 처리한다.
        if ($entity->getStatus() === static::STATUS_ACTIVATED) {
            throw new CannotDeleteActivatedPluginException();
        }

        $entity->getObject()->uninstall();
    }

    /**
     * 활성화 된 플러그인을 부팅한다. 이 메소드는 모든 요청에서 항상 호출되며, 활성화 된 모든 플러그인의 boot()메소드를 호출한다.
     * 각 플러그인은 모든 요청에서 항상 작동되어야 할 작업을 boot() 메소드로 작성해 놓아야 한다.
     *
     * @return void
     */
    public function bootPlugins()
    {
        foreach ($this->getActivatedPlugins() as $entity) {
            $this->bootingPlugin = $entity->getId();

            $this->bootPlugin($entity);
        }
    }

    /**
     * 플러그인을 부트한다.
     *
     * @param PluginEntity $entity 부트시킬 플러그인
     *
     * @return void
     */
    public function bootPlugin(PluginEntity $entity)
    {
        $pluginObj = $entity->getObject();

        // register & boot plugin's components
        $this->register->addByEntity($entity);
        $entity->bootComponents();

        // bind plugin to application
        $this->app->instance(get_class($pluginObj), $pluginObj);

        // boot plugin
        $pluginObj->boot();

        $this->registerViewNamespace($entity);
    }

    /**
     * 등록된 플러그인의 목록을 반환한다.
     *
     * @param bool $refresh true일 경우, cache를 사용하지 않고 다시 목록을 생성하여 반환한다.
     *
     * @return PluginCollection
     */
    public function getAllPlugins($refresh = false)
    {
        if ($refresh === true) {
            $this->plugins->initialize(true);
        }

        return $this->plugins;
    }

    /**
     * 활성화 된 플러그인의 목록을 반환한다.
     *
     * @return PluginEntity[]
     */
    public function getActivatedPlugins()
    {
        return $this->plugins->fetchByStatus(static::STATUS_ACTIVATED);
    }

    /**
     * 주어진 pluginId에 해당하는 플러그인을 조회하여 반환한다. PluginEntity 형태로 반환한다.
     *
     * @param string $pluginId 조회할 plugin의 id
     *
     * @return PluginEntity
     */
    public function getPlugin($pluginId)
    {
        return $this->plugins->get($pluginId);
    }

    /**
     * 플러그인 상태정보를 조회한다.
     *
     * @return mixed
     */
    protected function getPluginsStatus()
    {
        $configs = $this->config->getVal($this->configKey, []);
        return $configs;
    }

    /**
     * 플러그인 상태정보를 갱신한다.
     *
     * @param array $configs status list
     *
     * @return void
     */
    protected function setPluginsStatus(array $configs)
    {
        $this->config->setVal($this->configKey, $configs);
    }

    /**
     * 플러그인의 view namespace를 지정한다.
     *
     * @param PluginEntity $entity 플러그인
     *
     * @return void
     */
    private function registerViewNamespace(PluginEntity $entity)
    {
        $this->viewFactory->addNamespace($entity->getId(), $this->pluginsDir.'/'.$entity->getId());
    }

    /**
     * 플러그인이 활성화되었는지 조사한다.
     *
     * @param string $pluginId 조사할 플러그인 아이디
     *
     * @return bool 활성화된 플러그인일 경우 true 반환
     */
    public function isActivated($pluginId)
    {
        $plugin = $this->getPlugin($pluginId);
        if ($plugin === null) {
            return false;
        }
        return $plugin->isActivated();
    }
}
