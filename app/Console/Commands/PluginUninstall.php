<?php
namespace App\Console\Commands;

use File;
use Illuminate\Support\Collection;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

class PluginUninstall extends PluginCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'plugin:uninstall
                        {plugin* : The plugin for uninstall}
                        {--f|force : deactivate the plugin if plugin is activated.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall plugin of XpressEngine';

    /**
     * Create a new console command instance.
     *
     * @param PluginHandler       $handler
     * @param PluginProvider      $provider
     * @param ComposerFileWriter  $writer
     * @param InterceptionHandler $interceptionHandler
     */
    public function __construct(
        PluginHandler $handler,
        PluginProvider $provider,
        ComposerFileWriter $writer,
        InterceptionHandler $interceptionHandler
    ) {
        parent::__construct();

        $this->init($handler, $provider, $writer, $interceptionHandler);
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $data = $this->getPluginData($this->argument('plugin'));

        foreach ($data as $info) {
            if (!$info['is_dev']) {
                $this->prepareComposer();
                break;
            }
        }

        // 플러그인 정보 출력
        // 삭제 플러그인 정보
        $this->warn(PHP_EOL." Information of the plugin that should be uninstalled:");
        foreach ($data as $info) {
            $this->line('  '. $info['title'] .' - '. $info['name'].':'.$info['version'].PHP_EOL);
        }

        // 안내 멘트 출력
        // 위 플러그인을 삭제합니다. 플러그인을 삭제하면 사이트가 정상적으로 작동하지 않을 수 있습니다.
        $this->output->warning("Above plugin will be uninstalled. After the plugin is deleted, the site may not work well.");
        if ($this->input->isInteractive() && $this->confirm(
                "Above plugin will be uninstalled.  \r\n ".
                "After the plugin is uninstalled, the site may not work well. \r\n ".
                "It may take up to a few minutes. \r\n ".
                "Do you want to remove the plugin?"
            ) === false
        ) {
            return;
        }

        $this->checkActivated($data);

        // 플러그인 uninstall 실행
        $this->processUninstall($data);

        $plugins = Collection::make($data)->partition(function ($info) {
            return !$info['is_dev'];
        });

        $stables = $plugins->first();
        $develops = $plugins->last();

        if ($stables && count($stables) > 0) {
            $this->writeRequire($stables);

            $packages = array_pluck($stables, 'name');
            // composer update를 실행합니다. 최대 수분이 소요될 수 있습니다.
            $this->warn('Composer update command is running.. It may take up to a few minutes.');
            $this->line(" composer update --with-dependencies " . implode(' ', $packages));

            $result = $this->composerUpdate($packages);

            // composer 실행을 마쳤습니다.
            $this->warn('Composer update command is finished.'.PHP_EOL);

            $result = $this->writeResult($result);

            $this->printChangedPlugins($changed = $this->getChangedPlugins());

            if ($result) {
                $uninstalled = array_get($changed, 'uninstalled', []);
                if (count($uninstalled) < 1) {
                    $this->output->error(
                    // $name:$version 플러그인을 삭제하지 못했습니다. 플러그인 간의 의존관계로 인해 삭제가 불가능할 수도 있습니다.
                    // 플러그인 간의 의존성을 살펴보시기 바랍니다.
                        "Uninstall failed. Because of the dependencies between plugins, ".
                        "Uninstall may not be able to success. Please check the plugin's dependencies."
                    );
                }

                foreach ($uninstalled as $name => $version) {
                    $this->output->success("$name:$version plugin is uninstalled");
                }
            } else {
                $this->output->error("UnInstallation failed.");
            }
        }

        foreach ($develops as $info) {
            if (!File::deleteDirectory(plugins_path($info['id']))) {
                $this->output->block(
                    'Unable to remove plugin. Please delete the directory of plugin manually.',
                    'WARNING',
                    'fg=black;bg=yellow',
                    ' ',
                    true
                );
            } else {
                $this->output->success($info['name'].":".$info['version']." plugin is uninstalled");
            }
        }
        $this->clear();

    }

    /**
     * Get plugins data
     *
     * @param array $plugins
     * @return array
     * @throws \Exception
     */
    protected function getPluginData($plugins)
    {
        $data = [];
        foreach ($plugins as $key) {
            list($id, $version) = $this->parse($key);

            // 플러그인이 이미 설치돼 있는지 검사
            if (!$plugin = $this->handler->getPlugin($id)) {
                // 설치되어 있지 않은 플러그인입니다.
                throw new \Exception('Plugin not found');
            }

            $isDev = file_exists($plugin->getPath('vendor')) ? true : false;

            $data[] = [
                'id' => $id,
                'name' => $plugin->getName(),
                'version' => $plugin->getVersion(),
                'title' => $plugin->getTitle(),
                'plugin' => $plugin,
                'is_dev' => $isDev
            ];
        }

        return $data;
    }

    /**
     * Check activated
     *
     * @param array $data
     * @return void
     * @throws \Exception
     */
    protected function checkActivated(array $data)
    {
        foreach ($data as $info) {
            if ($info['plugin']->isActivated()) {
                if (!$this->option('force')) {
                    // 활성화된 플러그인은 삭제할 수 없습니다. 비활성화 한 후 삭제하려면 -f or --force 옵션을 사용하십시오.
                    throw new \Exception(
                        'It is not possible to uninstall the active plug-ins. ".
                        "If you want to deactivate plugin before uninstall, please use the -f or --force option.'
                    );
                }

                $this->handler->deactivatePlugin($info['id']);
            }
        }
    }

    /**
     * The process before delete plugin file
     *
     * @param array $data
     * @return void
     */
    protected function processUninstall(array $data)
    {
        foreach ($data as $info) {
            $this->handler->uninstallPlugin($info['id']);
        }
    }

    /**
     * Write require to composer.plugins.json
     *
     * @param array $data
     * @return void
     */
    protected function writeRequire($data)
    {
        // - plugins require info 갱신
        $this->writer->reset()->cleanOperation();

        foreach ($data as $info) {
            // composer.plugins.json 업데이트
            // - require에 설치할 플러그인 추가

            $this->writer->uninstall($info['name'], $this->getExpiredTime());
        }
        $this->writer->write();
    }
}
