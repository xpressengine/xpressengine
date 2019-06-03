<?php
/**
 * AbstractPlugin class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\Exceptions\CannotDeleteActivatedPluginException;
use Xpressengine\Plugin\Exceptions\PluginActivationFailedException;
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
     * 등록된 플러그인을 목록
     *
     * @var PluginCollection
     */
    protected $plugins;

    /**
     * @var PluginRepository
     */
    protected $repo;

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
     * Registered plugins
     *
     * @var array
     */
    protected $registered = [];

    /**
     * Booted plugins
     *
     * @var array
     */
    protected $booted = [];

    /**
     * An error occurred plugins
     *
     * @var array
     */
    protected $errors = [];

    /**
     * 생성자. 플러그인 관리에 필요한 요소들을 주입받는다.
     *
     * @param PluginRepository $repo        plugin repository
     * @param PluginProvider   $provider    plugin provider
     * @param Factory          $viewFactory View
     * @param PluginRegister   $register    plugin register
     * @param Application      $app         application
     */
    public function __construct(
        PluginRepository $repo,
        PluginProvider $provider,
        Factory $viewFactory,
        PluginRegister $register,
        Application $app
    ) {
        $this->repo = $repo;
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
        return $this->app['path.plugins'];
    }

    /**
     * plugin directory 경로를 지정한다.
     *
     * @param string $path 지정할 디렉토리 경로
     *
     * @return void
     *
     * @deprecated since 3.0.1
     */
    public function setPluginsDir($path)
    {
        // nothing
    }

    /**
     * get Unresolved Components
     *
     * @param string|null $plugin target plugin
     *
     * @return array
     */
    public function getUnresolvedComponents($plugin = null)
    {
        $unresolved = $this->register->getUnresolvedComponents();

        if ($plugin) {
            return array_get($unresolved, $plugin, []);
        }

        return $unresolved;
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

        // 플러그인이 존재하는지 검사한다.
        if ($entity === null) {
            throw new PluginNotFoundException(['pluginName' => $pluginId]);
        }

        // 플러그인이 이미 활성화되어있는 상태인지 체크한다.
        if ($entity->getStatus() === static::STATUS_ACTIVATED) {
            throw new PluginAlreadyActivatedException();
        }

        // 기존에 설치(활성화)된 적이 있는지 검사한다. 기존에 활성화된 적이 있다면 설치된 버전을 조회한다.
        $installedVersion = $entity->getInstalledVersion();

        // 플러그인의 컴포넌트 정보를 셋팅한다
        $entity->getObject();

        $this->updatePlugin($pluginId, false);

        // 플러그인 활성화. 플러그인을 활성화할 때마다 각 플러그인의 activate() 메소드를 호출해준다.
        try {
            $entity->activate($installedVersion);
        } catch (\Exception $e) {
            throw new PluginActivationFailedException([], null, $e);
        }

        $entity->setStatus(static::STATUS_ACTIVATED);
        $entity->setInstalledVersion($entity->getVersion());

        // 활성화 된 플러그인의 정보를 config에 기록한다.
        $this->setPluginStatus($pluginId, [
            'status' => static::STATUS_ACTIVATED,
            'version' => $entity->getVersion()
        ]);
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
            $dependencies = $this->getDependencies($activated);
            if (in_array($pluginId, $dependencies)) {
                throw new PluginDependencyException();
            }
        }

        // 기존에 설치(활성화)된 적이 있는지 검사한다. 기존에 활성화된 적이 있다면 설치된 버전을 조회한다.
        $installedVersion = $entity->getInstalledVersion();

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
        $this->setPluginStatus($pluginId, [
            'status' => static::STATUS_DEACTIVATED,
            'version' => $entity->getInstalledVersion()
        ]);
    }

    /**
     * 의존성 자료 정보를 반환함.
     *
     * @param PluginEntity $entity plugin entity
     * @return array
     */
    public function getDependencies(PluginEntity $entity)
    {
        // 이미 dependency 자료는 모두 composer를 통해 설치돼 있다고 가정한다.
        $dependencies = $entity->getMetaData('require');
        if ($dependencies === null) {
            $dependencies = [];
        }

        $collection = $this->getPlugins();
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
     * 플러그인을 업데이트한다.
     *
     * @param string $pluginId     업데이트할 플러그인의 아이디
     * @param bool   $updateStatus true일 경우, 업데이트한 플러그인의 상태를 status에 업데이트한다.
     *
     * @return void
     */
    public function updatePlugin($pluginId, $updateStatus = true)
    {
        $entity = $this->getPlugin($pluginId);

        // 플러그인이 존재하는지 검사한다.
        if ($entity === null) {
            throw new PluginNotFoundException(['pluginName' => $pluginId]);
        }

        $this->registerPlugin($entity);

        // 기존에 설치(활성화)된 적이 있다면 설치된 버전을 조사한다.
        $installedVersion = $entity->getInstalledVersion();

        // 플러그인이 설치되어 있는지 검사한다.
        if ($entity->checkInstalled() === false || $installedVersion === null) {
            $entity->install();
        }

        // 플러그인이 최신업데이트 상태인지 검사하고, 업데이트가 필요하면 업데이트 한다.
        if ($entity->checkUpdated($installedVersion) === false) {
            $entity->update($installedVersion);
        }

        if ($updateStatus) {
            // 플러그인의 정보를 config에 기록한다.
            $this->setPluginStatus($pluginId, [
                'status' => $entity->getStatus(),
                'version' => $entity->getVersion()
            ]);
        }
    }

    /**
     * 주어진 플러그인을 uninstall 한다.
     *
     * @param string $pluginId 삭제할 플러그인의 id
     *
     * @return void
     * @throws \Exception
     */
    public function uninstallPlugin($pluginId)
    {
        $entity = $this->getPlugin($pluginId);

        // 우선 활성화 상태인 플러그인인지 체크한다. 활성화 상태라면 삭제하지 않고 예외 처리한다.
        if ($entity->getStatus() === static::STATUS_ACTIVATED) {
            throw new CannotDeleteActivatedPluginException();
        }

        $this->registerPlugin($entity);

        $entity->getObject()->uninstall();

        // status list에서 해당 플러그인 정보를 삭제한다.
        $configs = $this->getPluginsStatus();
        array_forget($configs, $pluginId);
        $this->setPluginsStatus($configs);
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
            $this->registerPlugin($entity);
        }

        foreach ($this->getActivatedPlugins() as $entity) {
            $this->bootingPlugin = $entity->getId();

            $this->bootPlugin($entity);
        }
    }

    /**
     * 플러그인에서 제공하는 요소들을 바인딩한다.
     *
     * @param PluginEntity $entity 플러그인
     *
     * @return void
     */
    protected function registerPlugin(PluginEntity $entity)
    {
        try {
            if (!isset($this->registered[$entity->getId()]) && !isset($this->errors[$entity->getId()])) {
                $pluginObj = $entity->getObject();

                // register plugin's components
                $this->register->addByEntity($entity);

                // bind plugin to application
                $this->app->instance(get_class($pluginObj), $pluginObj);

                // boot plugin
                $pluginObj->register();

                $this->registerViewNamespace($entity);

                $this->registered[$entity->getId()] = true;
            }
        } catch (\Exception $e) {
            $this->handleError($entity, $e);
        } catch (\Throwable $e) {
            $this->handleError($entity, new FatalThrowableError($e));
        }
    }

    /**
     * 플러그인을 부트한다.
     *
     * @param PluginEntity $entity 부트시킬 플러그인
     *
     * @return void
     */
    protected function bootPlugin(PluginEntity $entity)
    {
        try {
            if (!isset($this->booted[$entity->getId()]) && !isset($this->errors[$entity->getId()])) {
                // boot plugin
                $entity->getObject()->boot();

                // boot plugin's components
                $entity->bootComponents($this->register);

                $this->booted[$entity->getId()] = true;
            }
        } catch (\Exception $e) {
            $this->handleError($entity, $e);
        } catch (\Throwable $e) {
            $this->handleError($entity, new FatalThrowableError($e));
        }
    }

    /**
     * Handle errors for boot plugins.
     *
     * @param PluginEntity $entity plugin
     * @param \Exception   $e      exception
     * @return void
     */
    protected function handleError(PluginEntity $entity, \Exception $e)
    {
        $this->errors[$entity->getId()] = [
            'entity' => $entity,
            'exception' => $e
        ];

        if ($entity->isActivated()) {
            $this->deactivatePlugin($entity->getId());
        }
    }

    /**
     * Returns errors for boot plugins.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
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
            $this->plugins = $this->refreshPlugins();

            // 각 플러그인의 설치된 버전과 실제버전이 다르고, 별도의 install이나 update가 필요없을 경우, 설치된 버전정보를 갱신한다.
            foreach ($this->plugins as $plugin) {
                /** @var PluginEntity $plugin */
                $installedVersion = $plugin->getInstalledVersion();
                $sourceVersion = $plugin->getVersion();

                if ($plugin->isActivated() && $sourceVersion !== $installedVersion) {
                    if ($plugin->checkInstalled() && $plugin->checkUpdated()) {
                        $this->setPluginStatus($plugin->getId(), [
                            'version' => $sourceVersion, 'status' => $plugin->getStatus()
                        ]);
                        $plugin->setInstalledVersion($sourceVersion);
                    }
                }

                // plugin 관리 기능을 위해 register 를 수행
                $this->registerPlugin($plugin);
            }
        }

        return $this->getPlugins();
    }

    /**
     * 등록된 플러그인의 목록을 반환한다.
     *
     * @return PluginCollection
     */
    public function getPlugins()
    {
        if (!$this->plugins) {
            $this->plugins = $this->createCollection($this->repo->load());
        }

        return $this->plugins;
    }

    /**
     * 설치된 플러그인 목록 캐시를 갱신한다.
     *
     * @return PluginCollection
     */
    public function refreshPlugins()
    {
        return $this->createCollection($this->repo->load(true));
    }

    /**
     * Create a new instance of the plugin collection.
     *
     * @param array $items plugins
     * @return PluginCollection
     */
    protected function createCollection($items)
    {
        return new PluginCollection($items);
    }

    /**
     * 플러그인이 composer autoload 파일을 가지고 있을 경우 autoload를 등록한다.
     *
     * @param PluginEntity $entity plugin
     * @return void
     */
    public function registerAutoload(PluginEntity $entity)
    {
        if ($entity->hasAutoload()) {
            $autoloadFile = $entity->getAutoloadFile();
            require $autoloadFile;
        }
    }

    /**
     * 활성화 된 플러그인의 목록을 반환한다.
     *
     * @return PluginEntity[]
     */
    public function getActivatedPlugins()
    {
        return $this->getPlugins()->fetchByStatus(static::STATUS_ACTIVATED);
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
        return $this->getPlugins()->get($pluginId);
    }

    /**
     * 플러그인들의 상태정보를 조회한다.
     *
     * @return mixed
     */
    protected function getPluginsStatus()
    {
        $configs = $this->config->getVal($this->configKey, []);
        return $configs;
    }

    /**
     * 주어진 플러그인의 상태정보를 조회한다.
     *
     * @param string $pluginId plugin id
     * @param null   $field    'version' or 'status'
     *
     * @return mixed
     */
    protected function getPluginStatus($pluginId, $field = null)
    {
        if ($field === null) {
            $configKey = $pluginId;
        } else {
            $configKey = $pluginId.'.'.$field;
        }
        $configs = $this->getPluginsStatus();
        return array_get($configs, $configKey);
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
     * 주어진 plugin의 상태를 갱신한다.
     * 상태정보에는 status, version 필드가 있으며, 둘중 하나만 선택해서 갱신할 수도 있다.
     *
     * @param string $pluginId plugin id
     * @param array  $field    'version' or 'status'
     * @param null   $status   value of field
     *
     * @return void
     */
    protected function setPluginStatus($pluginId, $field, $status = null)
    {
        if ($status === null) {
            $status = $field;
            $field = null;
            $configKey = $pluginId;
        } else {
            $configKey = $pluginId.'.'.$field;
        }
        $configs = $this->getPluginsStatus();
        array_set($configs, $configKey, $status);
        $this->setPluginsStatus($configs);
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
        $this->viewFactory->addNamespace($entity->getId(), $this->getPluginsDir().'/'.$entity->getId());
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

//    /**
//     * 현재 진행중인 플러그인 설치 작업 내역을 반환한다.
//     *
//     * @param ComposerFileWriter $writer composer file writer
//     *
//     * @return array|null
//     */
//    public function getOperation(ComposerFileWriter $writer)
//    {
//        $status = $writer->get('xpressengine-plugin.operation.status');
//
//        if ($status === null) {
//            return null;
//        }
//
//        $targets = [];
//        $installs = $writer->get("xpressengine-plugin.operation.todo.install", []);
//        foreach ($installs as $p => $v) {
//            $targets[$p] = [
//                'version' => $v,
//                'operation' => 'install',
//                'id' => explode('/', $p)[1]
//            ];
//        }
//        $updates = $writer->get("xpressengine-plugin.operation.todo.update", []);
//        foreach ($updates as $p => $v) {
//            $targets[$p] = [
//                'version' => $v,
//                'operation' => 'update',
//                'id' => explode('/', $p)[1]
//            ];
//        }
//        $uninstalls = $writer->get("xpressengine-plugin.operation.todo.uninstall", []);
//        foreach ($uninstalls as $p) {
//            $targets[$p] = [
//                'operation' => 'uninstall',
//                'id' => explode('/', $p)[1]
//            ];
//        }
//
//        // expired 조사
//        $deadline = $writer->get('xpressengine-plugin.operation.expiration_time');
//        $expired = false;
//        if ($deadline !== null && $deadline !== 0) {
//            $deadline = Carbon::parse($deadline);
//            if ($deadline->isPast()) {
//                $expired = true;
//            }
//        }
//
//        $changed = $writer->get('xpressengine-plugin.operation.changed', []);
//        $failed = $writer->get('xpressengine-plugin.operation.failed', []);
//
//        if ($status === ComposerFileWriter::STATUS_RUNNING && $expired === true) {
//            $writer->set('xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_EXPIRED);
//            $writer->set('xpressengine-plugin.lock', false);
//            $writer->write();
//            $status = ComposerFileWriter::STATUS_EXPIRED;
//        }
//
//        $logFile = $writer->get('xpressengine-plugin.operation.log');
//
//        if ($logFile && file_exists(storage_path($logFile))) {
//            $log = file_get_contents(storage_path($logFile));
//        } else {
//            $log = null;
//        }
//
//        $locked = $writer->get('xpressengine-plugin.lock', false);
//
//        return compact('targets', 'status', 'expired', 'changed', 'failed', 'log', 'locked');
//    }

    /**
     * 컴포넌트를 Register에 추가한다.
     *
     * @param string $component component class name
     *
     * @return void
     */
    public function addComponent($component)
    {
        $this->register->add($component);
    }
}
